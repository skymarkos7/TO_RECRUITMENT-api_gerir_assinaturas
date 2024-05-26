<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use App\Models\User;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Exists;

class InvoiceController extends Controller
{
    // GET
    public function getAllinvoices()
    {
        try {
            $invoices = Invoice::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($invoices) == 0) {
            return response()->json([
                'message' => 'Ainda não há invoices cadastradas.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $invoices,
            'code' => 200
        ], 200);
    }

    // GET
    public function getInvoice($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da invoice', 'code' => 400], 400);

        try {
            $invoiceExist = Invoice::where('id', $id)
                ->exists();

            if (!$invoiceExist) return response()->json(['message' => 'O ID informado não é de uma invoice válida', 'code' => 406], 406);

            $invoices = Invoice::find($id);

            if ($invoices == null) {
                return response()->json([
                    'message' => 'A invoice buscada não existe',
                    'code' => 204
                ], 204);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        return response()->json([
            'data' => $invoices,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertInvoice(Request $request)
    {
        // return $request;
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: signature_id, description, due_date, amount e status são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            if (!$this->validatorUserAndSignature($request)) {
                return response()->json([
                    'message' => 'O ID da signature informados não é válido, favor informe um ID de signature válido',
                    'code' => 406
                ], 406);
            }

            $invoiceEmitida = Signature::where('id', $request->signature_id)
                ->where('status_invoice', 'emitido')
                ->exists();

            if ($invoiceEmitida) {
                return response()->json([
                    'message' => 'A invoice para essa signature já foi emitida, insira uma outra signature.',
                    'code' => 306
                ], 306);
            }

            $invoice = Invoice::create([
                'signature_id' => $request->signature_id,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'amount' => $request->amount,
                'status' => $request->status,
            ]);

            Signature::where('id', $request->signature_id)
                ->update([
                    'status_invoice' => 'emitido',
                ]);

            return response()->json([
                'message' => 'A invoice foi criada com sucesso!',
                'data' => $invoice,
                'code' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a inserção',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // PUT
    public function updateInvoice(Request $request, $id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: signature_id, description, due_date, amount e status são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da invoice'], 400);

            $invoiceExist = Invoice::where('id', $id)
                ->exists();

            if (!$invoiceExist) return response()->json(['message' => 'O ID da invoice informada na não existe', 'code' => 406], 406);

            if (!$this->validatorUserAndSignature($request)) {
                return response()->json([
                    'message' => 'O ID da signature informados não é válido, favor informe um ID de signature válido',
                    'code' => 406
                ], 406);
            }

            Invoice::where('id', $id)
                ->update([
                    'signature_id' => $request->signature_id,
                    'description' => $request->description,
                    'due_date' => $request->due_date,
                    'amount' => $request->amount,
                    'status' => $request->status,
                ]);

            return response()->json([
                'message' => 'O invoice foi atualizado com sucesso!',
                'data' => Invoice::find($id),
                'code' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a atualização',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    // DELETE
    public function deleteinvoice($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da invoice', 'code' => 400], 400);

        try {
            $invoiceExist = Invoice::where('id', $id)
                ->exists();

            if (!$invoiceExist) return response()->json(['message' => 'O ID informado não é de uma invoice válida', 'code' => 406], 406);

            Invoice::where('id', $id)->delete();

            return response()->json([
                'message' => 'A invoice com ID ' . $id . ' foi deletada com sucesso!',
                'data' => Invoice::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar a invoice',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->signature_id) || !isset($request->description) || !isset($request->due_date) || !isset($request->amount) || !isset($request->status)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'signature_id' => 'required|integer',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
            'status' => 'required|string|in:pago,pendente',
        ]);

        return $validator->fails() ? $validator : false;
    }

    function validatorUserAndSignature($request)
    {
        $signatureExist = Signature::where('id', $request->signature_id)
            ->exists();

        return $signatureExist ? true : false;
    }
}
