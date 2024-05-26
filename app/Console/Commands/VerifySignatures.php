<?php

namespace App\Console\Commands;

use App\Models\Signature;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerifySignatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verify-signatures';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all assignatures which expire in less than 10 days
        $signatures = Signature::whereDate('due_date', '<=', Carbon::today()->addDays(10))
            ->where('status_invoice', 'aguardando')
            ->get();

        if (count($signatures) > 0) {
            $quantitySignatures = count($signatures);
            try {
                foreach ($signatures as $signature) {
                    Invoice::create([
                        'signature_id' => $signature->id,
                        'description' => $signature->description,
                        'amount' => $signature->amount,
                        'due_date' => $signature->due_date,
                        'status' => 'pendente',
                    ]);

                    Signature::where('id', $signature->id)
                        ->update([
                            'status_invoice' => 'emitido',
                        ]);
                }

                $this->info('Havia '. $quantitySignatures . ' assinaturas com data inferior ou igual a 10 dias para o vencimento e foram lançadas como faturas');

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Ocorreu um erro ao realizar o lançamento das faturas',
                    'info' => $e->getMessage(),
                    'code' => 500
                ], 500);
        }
        } else {
            $this->info('Não há assinaturas com data de vencimento menor ou igual a 10 dias');
        }
    }
}
