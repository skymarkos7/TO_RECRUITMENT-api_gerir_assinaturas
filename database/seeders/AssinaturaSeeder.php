<?php

namespace Database\Seeders;

use App\Models\Assinatura;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssinaturaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            'XYZKXX',
            'PUIOST',
            'TYVMSD',
            'HHDZXC',
            'QLSDFG',
            'TASDPP',
            'ADMSKK',
            'IOESDS',
            'PPASDM',
            'XYZKVT',
        ];

        $statusFatura = [
            'emitido ',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando',
            'aguardando ',
        ];

        $descricao = [
            'netflix',
            'netflix',
            'youtube',
            'amazon',
            'disney',
            'disney',
            'disney',
            'youtube',
            'amazon',
            'youtube',
        ];

        $valor = [
            '42',
            '55',
            '14',
            '96',
            '14',
            '93',
            '24',
            '95',
            '79',
            '22',
        ];

        try {
            for ($i = 0; $i < 10; $i++) {
                Assinatura::create([
                    'user' => $users[$i],
                    'descricao' => $descricao[$i],
                    'vencimento' => Carbon::now()->addDays($i+5),
                    'valor' => $valor[$i],
                    'status_fatura' => $statusFatura[$i],
                ]);
            }

            dd('Os users foram inseridos com sucesso!');

        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a inserção dos users '. $e->getMessage());
        }
    }
}
