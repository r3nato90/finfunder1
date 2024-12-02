<?php

namespace Database\Seeders;

use App\Enums\Email\EmailSmsTemplateName;
use App\Models\EmailSmsTemplate;
use Illuminate\Database\Seeder;

class EmailSmsTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $emailSmsTemplates = [
            [
                'code' => EmailSmsTemplateName::AGENT_CREDENTIALS->value,
                'name' => "Agent Credentials",
                'subject' => "Agent Credentials for access",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Please find your login credentials below: Email: [email] Password: [Password] If you encounter any issues or need further assistance, feel free to reach out.",
                'sms_template' => "Please find your login credentials below: Email: [email] Password: [Password] If you encounter any issues or need further assistance, feel free to reach out.",
                'short_key' => [
                    'email' => "Email Address",
                    'password' => "Password",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::PASSWORD_RESET_CODE->value,
                'name' => "Password Reset for User",
                'subject' => "Password Reset mail",
                'from_email' => "demo@gmail.com",
                'mail_template' => "We have received a request to reset the password for your account",
                'sms_template' => "Your account recovery code is: [token]",
                'short_key' => [
                    'token' => "Password Reset Code",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::ADMIN_PASSWORD_RESET_CODE->value,
                'name' => "Admin Password Reset",
                'subject' => "admin Password Reset mail",
                'from_email' => "demo@gmail.com",
                'mail_template' => "We have received a request to reset the password for your account",
                'sms_template' => "Your account recovery code is: [code]",
                'short_key' => [
                    'code' => "Password Reset Code",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_ADD->value,
                'name' => "Balance add by admin",
                'subject' => "Your Account has been credited",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Payment Confirm",
                'sms_template' => "Payment Confirm",
                'short_key' => [
                    'amount' => "Request Amount by admin",
                    'wallet_name' => "Wallet Name",
                    'currency' => "Site Currency",
                    'post_balance' => 'Users Balance After this operation'
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_SUBTRACT->value,
                'name' => "Balance subtract by admin",
                'subject' => "Your Account has been debited",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Payment Confirm",
                'sms_template' => "Payment Confirm",
                'short_key' => [
                    'amount' => "Request Amount by admin",
                    'wallet_type' => "Wallet Name",
                    'currency' => "Site Currency",
                    'post_balance' => 'Users Balance After this operation'
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_REQUEST->value,
                'name' => "Withdraw Request",
                'subject' => "Withdraw Request",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Withdraw Request",
                'sms_template' => "Withdraw Request",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_APPROVED->value,
                'name' => "Withdraw Approved",
                'subject' => "Withdraw Approved",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Withdraw Approved",
                'sms_template' => "Withdraw Approved",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::WITHDRAW_REJECTED->value,
                'name' => "Withdraw Rejected",
                'subject' => "Withdraw Rejected",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Withdraw Rejected",
                'sms_template' => "Withdraw Rejected",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::DEPOSIT_APPROVED->value,
                'name' => "Approved Deposit",
                'subject' => "Deposit Approved",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Deposit",
                'sms_template' => "Deposit",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::TRADITIONAL_DEPOSIT->value,
                'name' => "Traditional Deposit",
                'subject' => "Traditional Deposit",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Traditional deposit",
                'sms_template' => "Traditional deposit",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::DEPOSIT_REJECTED->value,
                'name' => "Deposit rejected",
                'subject' => "Deposit rejected",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Deposit rejected",
                'sms_template' => "Deposit rejected",
                'short_key' => [
                    'amount' => "Amount",
                    'charge' => "Charge",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::PIN_RECHARGE->value,
                'name' => "Pin recharge",
                'subject' => "Pin recharge",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Pin recharge",
                'sms_template' => "Pin recharge",
                'short_key' => [
                    'currency' => "Currency Symbol",
                    'amount' => "Amount",
                    'pin_number' => "Pin Number",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::REFERRAL_COMMISSION->value,
                'name' => "Referral Commission",
                'subject' => "Referral Commission",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Referral Commission",
                'sms_template' => "Referral Commission",
                'short_key' => [
                    'amount' => "Amount",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::LEVEL_COMMISSION->value,
                'name' => "Level Commission",
                'subject' => "Level Commission",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Level Commission",
                'sms_template' => "Level Commission",
                'short_key' => [
                    'amount' => "Amount",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_SCHEME_PURCHASE->value,
                'name' => "Investment Scheme purchase",
                'subject' => "Invest Scheme",
                'from_email' => "demo@gmail.com",
                'mail_template' => "invest",
                'sms_template' => "invest",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_COMPLETE->value,
                'name' => "Investment Complete",
                'subject' => "Invest Complete",
                'from_email' => "demo@gmail.com",
                'mail_template' => "invest complete",
                'sms_template' => "invest complete",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::RE_INVESTMENT->value,
                'name' => "Re Investment",
                'subject' => "Re Investment",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Re Invest",
                'sms_template' => "Re Invest",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_CANCEL->value,
                'name' => "Investment Cancel",
                'subject' => "Investment Cancel",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Investment Cancel",
                'sms_template' => "Investment Cancel",
                'short_key' => [
                    'amount' => "Amount",
                    'interest_rate' => "Interest Rate",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::MATRIX_ENROLLED->value,
                'name' => "Matrix Enrolled",
                'subject' => "Matrix Enrolled",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Matrix Enrolled",
                'sms_template' => "Matrix Enrolled",
                'short_key' => [
                    'amount' => "Amount",
                    'referral_commission' => "Referral Commission",
                    'plan_name' => "Plan Name",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::BALANCE_TRANSFER_RECEIVE->value,
                'name' => "Balance transfer receive",
                'subject' => "Balance transfer receive",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Balance transfer receive",
                'sms_template' => "Balance transfer receive",
                'short_key' => [
                    'amount' => "Amount",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::INVESTMENT_PLAN_NOTIFY->value,
                'name' => "Invest Plan create notify",
                'subject' => "Investment plan notify",
                'from_email' => "demo@gmail.com",
                'mail_template' => "Investment plan notify",
                'sms_template' => "Investment plan notify",
                'short_key' => [
                    'name' => "Plan name",
                    'amount' => "Amount",
                    'minimum' => "Minimum Amount",
                    'maximum' => "Maximum Amount",
                    'interest_rate' => "Interest Rate",
                    'currency' => 'Currency Symbol',
                    'duration' => "Duration",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
            [
                'code' => EmailSmsTemplateName::STAKING_INVESTMENT_NOTIFY->value,
                'name' => "Staking Investment Notify",
                'subject' => "Staking Invest",
                'from_email' => "demo@gmail.com",
                'mail_template' => "invest",
                'sms_template' => "invest",
                'short_key' => [
                    'amount' => "Amount",
                    'interest' => "Interest",
                    'expiration_date' => "Expiration Date",
                    'currency' => "Currency",
                ],
                'status' => \App\Enums\Status::ACTIVE->value,
            ],
        ];

        EmailSmsTemplate::truncate();
        collect($emailSmsTemplates)->each(fn($emailSmsTemplate) => EmailSmsTemplate::create($emailSmsTemplate));
    }
}

