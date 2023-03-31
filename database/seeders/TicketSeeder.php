<?php

namespace Database\Seeders;

use App\Models\Comedian;
use App\Models\Place;
use App\Models\Sessions;
use App\Models\Tickets;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{

    public function run()
    {


        foreach ($this->dataSet() as $item) {
            Tickets::create([
                'id' => $item["id"],
                'owner_id' => $item["owner_id"],
                'attraction_id' => $item["attraction_id"],
                'status' => $item["status"],
                'payed_at' => $item["payed_at"],
                'checkin_at' => $item["checkin_at"],
                'created_at' => $item["created_at"],
                'updated_at' => $item["updated_at"],
                'session_id' => '642660f112d9a'
            ]);
        }
    }

    public function dataSet() {
        return [[
            "id" => uniqid(),
            "owner_id" => '63d1c98e22ccb',
            "attraction_id" => '63d332d50ff63',
            "status" => 'paid',
            "payed_at" => new \DateTimeImmutable(),
            "checkin_at" =>  new \DateTimeImmutable(),
            "created_at" => new \DateTimeImmutable(),
            "updated_at" => new \DateTimeImmutable(),
        ], [
            "id" => uniqid(),
            "owner_id" => '63d1c98e22ccb',
            "attraction_id" => '63d332d50ff63',
            "status" => 'paid',
            "payed_at" => new \DateTimeImmutable(),
            "checkin_at" => null,
            "created_at" => new \DateTimeImmutable(),
            "updated_at" => new \DateTimeImmutable(),
        ]];
    }

}
