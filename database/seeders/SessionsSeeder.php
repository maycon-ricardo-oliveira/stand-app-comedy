<?php

namespace Database\Seeders;

use App\Models\Sessions;
use Illuminate\Database\Seeder;

class SessionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Sessions::create([
            "id" => '642660f112d9a',
            "attraction_id" => "63d332d50ff63",
            "session_code" => "EAP-230331-0426",
            "tickets" => 10,
            "tickets_sold" => 0,
            "tickets_validated" => 0,
            "start_at" => "21:00:00",
            "finish_at" => "22:00:00",
            "status" => "draft",
            "created_at" => new \DateTimeImmutable(),
            "updated_at" => new \DateTimeImmutable(),
            "created_by" => '63d1c98e22ccb',
        ]);
    }
}
