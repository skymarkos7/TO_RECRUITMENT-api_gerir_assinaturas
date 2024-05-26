<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Fatura;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            Fatura::create([
                'user' => 'XYZKVT',
                'assinatura'=> 10,
                'descricao' => 'youtube',
                'vencimento' => Carbon::now()->addDays(1),
                'valor' => 22,
                'status' => 'pago',
            ]);

            dd('Os users foram inseridos com sucesso!');

        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a inserção dos users '. $e->getMessage());
        }
    }
}
