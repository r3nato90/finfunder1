<?php

namespace App\Enums;

enum PageIdentifier: int
{
    use EnumTrait;

    case MATRIX = 1;
    case MATRIX_ENROLLED = 2;
    case BINARY = 3;
    case BINARY_INVESTMENT = 4;
    case DAILY_COMMISSIONS = 5;
    case COMMISSIONS = 6;
    case PIN_GENERATE = 7;
    case LANGUAGE = 8;
    case TRADE_PARAMETER = 9;
    case CRYPTO_CURRENCY = 10;
    case TRADE = 11;
    case PAYMENT_GATEWAY = 12;
    case MANUAL_PAYMENT_GATEWAY = 13;
    case DEPOSIT = 14;
    case WITHDRAW_METHOD = 15;
    case WITHDRAW_LOG = 16;
    case SUPPORT_TICKET = 17;
    case USER = 18;
    case MENU = 19;
    case MENU_ITEMS = 20;
    case SMS_EMAIL_TEMPLATES = 21;
    case BLOCK_IP = 22;
    case FIREWALL_LOG = 23;
    case TRANSACTIONS = 24;
    case SMS_GATEWAYS = 25;
    case SUBSCRIBER = 26;
    case CONTACT = 27;
    case CRON = 28;
    case TIME_TABLE = 29;
    case HOLIDAY_SETTING = 30;
    case STAKING_PLAN = 31;
    case STAKING_INVESTMENT = 32;
    case KYC_IDENTITY = 33;
    case REWARD = 34;
    case AGENT = 35;
    case AGENT_TRANSACTIONS = 36;
    case AGENT_WITHDRAW_LOG = 37;


}
