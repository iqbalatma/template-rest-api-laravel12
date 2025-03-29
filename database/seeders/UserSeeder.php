<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public const array DATA = [
        [
            "id" => "0195c52b-a15e-72a9-9fa0-55075b292001",
            "name" => "iqbal atma muliawan",
            "username" => "iqbalatma",
            "email" => "iqbalatma@gmail.com",
            "password" => "admin",
        ]
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DATA as $user){
            User::query()->create($user);
        }
    }
}
