<?php

namespace Database\Seeders;

use App\Enums\SMS\SmsGatewayName;
use App\Enums\SMS\SmsGatewayStatus;
use App\Models\SmsGateway;
use Illuminate\Database\Seeder;

class SmsGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smsGateways = [
            [
                'code' => SmsGatewayName::TWILIO->value,
                'name' => 'Twilio SMS Gateway',
                'credential' => [
                    'account_sid' => 'demo',
                    'auth_token' => "demo",
                    'from_number' => 'demo'
                ],
                'status' => SmsGatewayStatus::ACTIVE->value
            ],
            [
                'code' => SmsGatewayName::BIRD->value,
                'name' => 'Message Bird SMS Gateway',
                'credential' => [
                    'access_key' => 'demo',
                ],
                'status' => SmsGatewayStatus::ACTIVE->value
            ],
            [
                'code' => SmsGatewayName::MAGIC->value,
                'name' => 'Text Magic SMS Gateway',
                'credential' => [
                    'api_key' => 'demo',
                    'text_magic_username' => "demo"
                ],
                'status' => SmsGatewayStatus::ACTIVE->value
            ],
        ];
        SmsGateway::truncate();
        collect($smsGateways)->each(fn($smsGateway) => SmsGateway::create($smsGateway));
    }
}


