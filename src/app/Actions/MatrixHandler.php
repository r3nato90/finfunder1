<?php

namespace App\Actions;

use App\Enums\CommissionType;
use App\Enums\Email\EmailSmsTemplateName;
use App\Enums\Transaction\Source;
use App\Enums\Transaction\Type;
use App\Enums\Transaction\WalletType;
use App\Jobs\EmailSmsProcessJob;
use App\Models\Matrix;
use App\Models\User;
use App\Services\Investment\CommissionService;
use App\Services\Investment\MatrixService;
use App\Services\Payment\TransactionService;
use App\Services\Payment\WalletService;
use Exception;

class MatrixHandler
{

    /**
     * @throws Exception
     */
    public function __construct(
        protected User $user,
        protected Matrix $plan,
    ){
        $this->getException();
    }

    /**
     * Purchase user plan
     * @return void;
     */
    public function store(): void
    {
        $this->getPosition();
        $this->referralRewardCommission();
        $this->distributeLevelCommissions();
    }

    public function getPosition(): bool
    {
        if (!$this->user->referredBy) {
            return false;
        }

        $referral = $this->user->referredBy;
        $nextPosition = $this->getNextPosition($referral->id);

        if ($nextPosition) {
            $this->setPosition($this->user, (int)$referral->id, (int)$nextPosition);
            return true;
        }

        return $this->loopThroughPositions($referral);
    }

    private function loopThroughPositions($referral): bool
    {
        $isPositionSet = false;

        for ($level = 1; $level < 100000; $level++) {
            $positions = $this->getPositionsBelow((int)$referral->id, $level);

            foreach ($positions as $position) {
                $nextPosition = $this->getNextPosition($position);

                if ($nextPosition) {
                    $this->setPosition($this->user, $position, $nextPosition);
                    $isPositionSet = true;
                    break 2;
                }
            }
        }

        return $isPositionSet;
    }

    /**
     * Get all positions at a specific level below a user
     *
     * @param int $id
     * @param int $level
     * @return array
     */
    private function getPositionsBelow(int $id, int $level): array
    {
        $positions = [$id];

        for ($i = 0; $i < $level; $i++) {
            $positions = $this->expandPositions($positions);
        }

        return $positions;
    }

    /**
     * Expand positions based on immediate below users
     * @param array $positions
     * @return array
     */
    private function expandPositions(array $positions): array
    {
        $nextPositions = [];

        foreach ($positions as $position) {
            $nextPositions = array_merge($nextPositions, $this->showPositionBelow($position));
        }

        return $nextPositions;
    }

    /**
     * Set user's position details
     *
     * @param User $user
     * @param int $positionId
     * @param int $position
     */
    private function setPosition(User $user, int $positionId, int $position): void
    {
        $user->position_id = $positionId;
        $user->position = $position;
        $user->save();
    }

    /**
     * Get the next available position
     *
     * @param int $id
     * @return int
     */
    private function getNextPosition($id): int
    {
        $count = User::where('position_id', $id)->count();
        return ($count < MatrixService::getMatrixWidth()) ? $count + 1 : 0;
    }

    /**
     * Get all immediate below users
     * @param int $id
     * @return array
     */
    private function showPositionBelow($id): array
    {
        return User::where('position_id', $id)->pluck('id')->toArray();
    }

    public function referralRewardCommission(): void
    {
        if ($referral = $this->user->referredBy) {
            $amount = $this->plan->referral_reward;
            $wallet = $referral->wallet;
            $wallet->investment_balance += $this->plan->referral_reward;
            $wallet->save();

            $transaction = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);
            $commission = resolve(CommissionService::class);

            if ($matrixInvestment = $referral->matrixInvestemnt){
                $matrixInvestment->referral_commissions += $this->plan->referral_reward;
                $matrixInvestment->save();
            }

            $transaction->save($transaction->prepParams([
                'user_id' => $referral->id,
                'amount' => $amount,
                'type' => Type::PLUS,
                'details' => "Referral commission from ".$this->user->email,
                'wallet' => $walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));

            $commission->save($commission->prepParams($referral->id,"commission from ".$this->user->email,CommissionType::REFERRAL,$amount,$this->user->id));

            dispatch(new EmailSmsProcessJob($referral, [
                'amount' => shortAmount($amount),
                'currency' => getCurrencySymbol(),
            ], EmailSmsTemplateName::REFERRAL_COMMISSION->value));
        }
    }


    /**
     * Give direct level commission to upper
     * @return void
     */
    public function distributeLevelCommissions(): void
    {
        $user = $this->user->load('positionedAbove');
        $commissions = $this->plan->matrixLevel;
        $i = 0;

        foreach ($commissions as $commission) {
            $i++;
            if ($this->getHeight() <= 0 || !$user->positionedAbove) {
                break;
            }

            $upper = $user->positionedAbove->load('wallet');

            $wallet = $upper->wallet;
            $wallet->investment_balance += $commission->amount;
            $wallet->save();

            $transaction = resolve(TransactionService::class);
            $walletService = resolve(WalletService::class);
            $commissionService = resolve(CommissionService::class);

            $details = 'Level '.($i).' commission from '.$user->email;
            $transaction->save($transaction->prepParams([
                'user_id' => $upper->id,
                'amount' =>  $commission->amount,
                'type' => Type::PLUS,
                'details' => $details,
                'wallet' => $walletService->findBalanceByWalletType(WalletType::INVESTMENT->value, $wallet),
                'source' => Source::INVESTMENT->value
            ]));

            if ($matrixInvestment = $upper->matrixInvestemnt){
                $matrixInvestment->level_commissions += $commission->amount;
                $matrixInvestment->save();
            }

            dispatch(new EmailSmsProcessJob($upper, [
                'amount' => shortAmount($commission->amount),
                'currency' => getCurrencySymbol(),
            ], EmailSmsTemplateName::LEVEL_COMMISSION->value));

            $commissionService->save($commissionService->prepParams($upper->id, $details, CommissionType::LEVEL, $commission->amount, $user->id));
            $user = $upper;
        }
    }


    private function getHeight(): int
    {
        return MatrixService::getMatrixHeight();
    }


    private function getWidth(): int
    {
        return MatrixService::getMatrixWidth();
    }

    /**
     * Checks various conditions and throws exceptions if any are met.
     * @return void
     * @throws Exception If the user already has a matrix investment, does not have sufficient balance, or the referrer's plan does not match.
     */
    private function getException(): void
    {
        if ($this->user->matrixInvestment) {
            throw new Exception('You can\'t buy plan twice');
        }

        if ($this->user->wallet->primary_balance < $this->plan->amount) {
            throw new Exception('You don\'t have sufficient balance');
        }

        $referral = $this->user->referredBy;

        if ($referral && $referral->matrixInvestment && $referral->matrixInvestment->plan_id != $this->plan->id) {
            throw new Exception('You have to purchase a plan which your referrer has purchased');
        }
    }

}
