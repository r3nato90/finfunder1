<?php

namespace App\Enums\Transaction;

use App\Enums\EnumTrait;

enum WalletType: int
{
    use EnumTrait;

    case PRIMARY = 1;
    case INVESTMENT = 2;
    case TRADE = 3;
    case PRACTICE = 4;

    public static function getName(int $status): string {
        return match ($status) {
            self::PRIMARY->value => 'Primary Balance',
            self::INVESTMENT->value =>  'Investment Balance',
            self::TRADE->value => 'Trade Balance',
            self::PRACTICE->value => 'Practice Balance',
            default => 'Default'
        };
    }

    /**
     * @param int $status
     * @return string
     */
    public static function getColor(int $status): string {
        return match($status) {
            self::PRIMARY->value => 'badge--primary',
            self::INVESTMENT->value =>  'badge--success',
            self::TRADE->value => 'badge--info',
            self::PRACTICE->value => 'badge--warning',
            default => 'Default'
        };
    }

    public static function getColumn(int $status): string {
        return match ($status) {
            self::PRIMARY->value => 'primary_balance',
            self::INVESTMENT->value =>  'investment_balance',
            self::TRADE->value => 'trade_balance',
            self::PRACTICE->value => 'practice_balance',
            default => 'Default'
        };
    }

    public static function getWalletName(int $status): string {
        return match ($status) {
            self::PRIMARY->value => 'Primary Wallet',
            self::INVESTMENT->value =>  'Investment Wallet',
            self::TRADE->value => 'Trade Wallet',
            self::PRACTICE->value => 'Practice Wallet',
            default => 'Default'
        };
    }
}
