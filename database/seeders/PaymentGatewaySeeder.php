<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentGateway::create([
            "id" => uniqid(),
            "name" => 'stripe',
            "description" => 'stripe payment gateway',
            "is_active" => true,
            "currency" => 'BRL',
        ]);
    }
}
