<?php

namespace Database\Seeders;

use App\Models\Signature;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $signatures = Signature::all()
            ->where('status_invoice','<>', 'emitido')
            ->toArray();

        $signature = $signatures[array_rand($signatures)];
        $signatureId = $signature['id'];
        $signatureDescripttion = $signature['description'];
        $signatureAmount = $signature['amount'];

        try {
            Invoice::create([
                'signature_id'=> $signatureId,
                'description' => $signatureDescripttion,
                'due_date' => Carbon::now()->addDays(1),
                'amount' => $signatureAmount,
                'status' => 'pendente',
            ]);

            Signature::where('id', $signatureId)
                ->update([
                    'status_invoice' => 'emitido',
            ]);

            dd('A assinatura de '. $signatureDescripttion .' com ID '. $signatureId  .' foi convertida em fatura para pagemento com sucesso!');

        } catch (\Exception $e) {

            dd('Ocorreu um erro ao realizar a conversão da assinatura em fatura '. $e->getMessage());
        }
    }
}
