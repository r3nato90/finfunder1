<?php

namespace Database\Seeders;

use App\Enums\Payment\Withdraw\MethodStatus;
use App\Models\WithdrawMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WithdrawMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $withdrawMethods = [
            [
                "currency_name" => getCurrencyName(),
                "min_limit" => "1.00000000",
                "max_limit" => "100000.00000000",
                "percent_charge" => "1",
                "fixed_charge" => "12.00000000",
                "rate" => "1.00000000",
                "name" => "Bank Transfer",
                "file" => "62e7b2507c25f1659351632.png",
                "parameter" => [
                    "account_no" => [
                        "field_label" => "Account No.",
                        "field_name" => "account_no",
                        "field_type" => "text",
                    ],
                    "trx_id" => [
                        "field_label" => "TrxID",
                        "field_name" => "trx_id",
                        "field_type" => "text",
                    ],
                ],
                "status" => MethodStatus::ACTIVE->value,
                "instruction" => null,
            ],

            [
                "currency_name" => getCurrencyName(),
                "min_limit" => "100.00000000",
                "max_limit" => "500000.00000000",
                "percent_charge" => "5",
                "fixed_charge" => "30.00000000",
                "rate" => "1.00000000",
                "name" => "Western Union",
                "file" => "62e7b2507c25f1659351632.png",
                "parameter" => [
                    "account_no" => [
                        "field_label" => "Account No.",
                        "field_name" => "account_no",
                        "field_type" => "text",
                    ],
                    "trx_id" => [
                        "field_label" => "TrxID",
                        "field_name" => "trx_id",
                        "field_type" => "text",
                    ],
                ],
                "status" => MethodStatus::ACTIVE->value,
                "instruction" => null,
            ],
            [
                "currency_name" => getCurrencyName(),
                "min_limit" => "100.00000000",
                "max_limit" => "500000.00000000",
                "percent_charge" => "5",
                "fixed_charge" => "30.00000000",
                "rate" => "1.00000000",
                "name" => "Cash Pickup",
                "file" => "62e7b2507c25f1659351632.png",
                "parameter" => [
                    "account_no" => [
                        "field_label" => "Account No.",
                        "field_name" => "account_no",
                        "field_type" => "text",
                    ],
                    "trx_id" => [
                        "field_label" => "TrxID",
                        "field_name" => "trx_id",
                        "field_type" => "text",
                    ],
                ],
                "status" => MethodStatus::ACTIVE->value,
                "instruction" => null,
            ],
        ];

        WithdrawMethod::truncate();
        collect($withdrawMethods)->each(fn($withdrawMethod) => WithdrawMethod::create($withdrawMethod));

    }
}
