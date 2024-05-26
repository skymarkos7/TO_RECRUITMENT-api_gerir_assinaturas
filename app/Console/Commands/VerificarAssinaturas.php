<?php

namespace App\Console\Commands;

use App\Models\Signature;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Console\Command;

class VerificarSignatures extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:verificar-signatures';

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
                        'user' => $signature->user,
                        'signature' => $signature->id,
                        'description' => $signature->description,
                        'due_date' => $signature->due_date,
                        'amount' => $signature->amount,
                        'status' => 'pendente',
                    ]);

                    Signature::where('id', $signature->id)
                        ->update([
                            'status_invoice' => 'emitido',
                        ]);
                }

                $this->info('Foram lançadas '. $quantitySignatures . ' novas invoices');

            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Ocorreu um erro ao realizar o lançamento das invoices',
                    'info' => $e->getMessage(),
                    'code' => 500
                ], 500);
        }
        } else {
            $this->info('Não há signatures com data de due_date menor ou igual a 10 dias');
        }
    }
}
