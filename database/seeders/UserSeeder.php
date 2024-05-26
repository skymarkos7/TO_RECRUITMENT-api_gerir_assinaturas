<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        $qtUser = 10;

        try {
            for ($i = 0; $i < $qtUser; $i++) {
                User::create([
                    'name' => $faker->name,
                    'mail' => $faker->email,
                    'phone' =>$faker->phoneNumber,
                ]);
            }

            dd($qtUser.' '.'usuários foram inseridos com sucesso!');

        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a inserção dos usuários '. $e->getMessage());
        }
    }
}
