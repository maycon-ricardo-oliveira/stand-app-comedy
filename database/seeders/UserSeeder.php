<?php

namespace Database\Seeders;

use App\Chore\Adapters\DateTimeAdapter;
use App\Chore\Adapters\HashAdapter;
use App\Chore\Adapters\MySqlAdapter;
use App\Chore\Adapters\UniqIdAdapter;
use App\Chore\Infra\Memory\UserRepositoryMemory;
use App\Chore\Infra\MySql\UserDAODatabase;
use App\Chore\UseCases\UserRegister\UserRegister;
use App\Models\Comedian;
use App\Models\User;
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
            "name" => 'Afonso Padilha',
            "email" => 'afonso.padilha@gmail.com',
            "password" => 'password',
        ], [
            "name" => 'Rodrigo Marques',
            "email" => 'rodrigo.marques@gmail.com',
            "password" => 'password',
        ], [
            "name" => 'User Test',
            "email" => 'user.test63cb4a1551081@gmail.com',
            "password" => 'password',
        ]];
    }

}
