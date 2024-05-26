<?php

namespace Database\Seeders;

use App\Models\Signature;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SignatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $statusInvoice = [
            'emitido ',
            'emitido',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando ',
        ];

        $description = [
            'netflix',
            'hbo max',
            'youtube',
            'amazon',
            'mercado livre',
            'disney',
            'youtube',
            'amazon prime',
            'globo',
        ];

        $users = User::all()->toArray();

        $qtSignature = 10;

        try {
            for ($i = 0; $i < $qtSignature; $i++) {

                Signature::create([
                    'user_id' => $users[array_rand($users)]['id'],
                    'description' => $description[array_rand($description)],
                    'due_date' => Carbon::now()->addDays($i + 5),
                    'amount' => $faker->randomFloat(1, 20, 30),
                    'status_invoice' => $statusInvoice[array_rand($statusInvoice)],
                ]);
            }

            dd($qtSignature . ' ' . 'as assinaturas foram inseridas com sucesso!');
        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a inserção das assinaturas ' . $e->getMessage());
        }
    }
}
