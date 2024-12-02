<?php

namespace App\Enums\Email;

use App\Enums\EnumTrait;

enum EmailSmsTemplateName: string
{
    use EnumTrait;

    case PASSWORD_RESET_CODE ='password_reset_code';
    case ADMIN_PASSWORD_RESET_CODE ='admin_password_reset_code';
    case BALANCE_ADD = 'balance_add';
    case BALANCE_SUBTRACT = 'balance_subtract';
    case WITHDRAW_REQUEST = 'withdraw_request';
    case WITHDRAW_APPROVED = 'withdraw_approved';
    case WITHDRAW_REJECTED = 'withdraw_rejected';
    case DEPOSIT_APPROVED = 'deposit_approved';
    case TRADITIONAL_DEPOSIT = 'traditional_deposit';
    case DEPOSIT_REJECTED = 'deposit_rejected';
    case INVESTMENT_SCHEME_PURCHASE = 'investment_scheme_purchase';
    case INVESTMENT_COMPLETE  = 'investment_complete';
    case RE_INVESTMENT  = 're_invest';
    case INVESTMENT_CANCEL  = 'investment_cancel';
    case MATRIX_ENROLLED  = 'matrix_enrolled';
    case PIN_RECHARGE = 'pin_recharge';
    case REFERRAL_COMMISSION = 'referral_commission';
    case LEVEL_COMMISSION = 'level_commission';
    case BALANCE_TRANSFER_RECEIVE = 'balance_transfer_receive';
    case INVESTMENT_PLAN_NOTIFY = 'investment_plan_notify';
    case STAKING_INVESTMENT_NOTIFY = 'staking_investment_notify';
    case AGENT_CREDENTIALS = 'agent-credentials';
}
