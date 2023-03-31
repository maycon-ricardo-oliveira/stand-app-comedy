<?php

namespace Database\Seeders;

use App\Chore\Modules\Adapters\DateTimeAdapter\DateTimeAdapter;
use App\Chore\Modules\Adapters\HashAdapter\HashAdapter;
use App\Chore\Modules\Adapters\MySqlAdapter\MySqlAdapter;
use App\Chore\Modules\Adapters\UuidAdapter\UniqIdAdapter;
use App\Chore\Modules\User\Infra\MySql\UserDAODatabase;
use App\Chore\Modules\User\UseCases\UserRegister\UserRegister;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $date = new DateTimeAdapter();
        $mysql = new MySqlAdapter();
        $repository = new UserDAODatabase($mysql, $date);
        $hashAdapter = new HashAdapter();
        $uuidAdapter = new UniqIdAdapter();
        $useCase = new UserRegister($repository, $hashAdapter, $uuidAdapter);

        foreach ($this->dataSet() as $userData) {
            $useCase->handle($userData, $date);
        }

    }

    public function dataSet() {
        return [[
            "id" => "63d1c98e0038c",
            "name" => 'Afonso Padilha',
            "email" => 'afonso.padilha@gmail.com',
            "password" => 'password',
        ], [
            "id" => "63d1c98e1164a",
            "name" => 'Rodrigo Marques',
            "email" => 'rodrigo.marques@gmail.com',
            "password" => 'password',
        ], [
            "id" => "63d1c98e22ccb",
            "name" => 'User Test',
            "email" => 'user.test63cb4a1551081@gmail.com',
            "password" => 'password',
        ]];
    }

}
