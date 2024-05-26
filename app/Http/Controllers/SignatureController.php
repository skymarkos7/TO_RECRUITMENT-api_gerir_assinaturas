<?php

namespace App\Http\Controllers;

use App\Models\Signature;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class SignatureController extends Controller
{
    // GET
    public function getAllSignatures()
    {
        try {
            $signatures = Signature::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($signatures) == 0) {
            return response()->json([
                'message' => 'Ainda não há assinaturas inseridas.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $signatures,
            'code' => 200
        ], 200);
    }

    // GET
    public function getSignature($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da assinatura', 'code' => 400], 400);

        try {
            $signatureExist = Signature::where('id', $id)
                ->exists();

            if (!$signatureExist) return response()->json(['message' => 'O ID informado não é de uma assinatura válida', 'code' => 406], 406);

            $signatures = Signature::find($id);

            if ($signatures == null) {
                return response()->json([
                    'message' => 'A assinatura buscada não existe',
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
            'data' => $signatures,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertSignatures(Request $request)
    {
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: user_id, descrição, due_date e amount são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            $userExist = User::where('id', $request->user_id)
                ->exists();

            if (!$userExist)
                return response()->json([
                        'message' => 'O user_id informado não é um ID válido, favor informe um ID de user válido',
                        'code' => 406
                    ],
                    406
                );

            $signature = Signature::create([
                'user_id' => $request->user_id,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'amount' => $request->amount,
                'status_invoice' => $request->status_invoice,
            ]);

            return response()->json([
                'message' => 'Assinatura inserida com sucesso',
                'data' => $signature,
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
    public function updateSignature(Request $request, $id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: user_id, description, due_date, amount, e status_invoice são obrigatórios',
            'code' => 400
        ], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da assinatura'], 400);

            $signatureExist = Signature::where('id', $id)
                ->exists();

            if (!$signatureExist) return response()->json(['message' => 'O ID da assinatura informada na URL não existe', 'code' => 406], 406);

            $userExist = user::where('id', $request->user_id)
                ->exists();

            if (!$userExist)
                return response()->json(['message' => 'O user_id informado não é um código válido, favor informe um ID de user válido', 'code' => 406], 406);

            Signature::where('id', $id)
                ->update([
                    'user_id' => $request->user_id,
                    'description' => $request->description,
                    'due_date' => $request->due_date,
                    'amount' => $request->amount,
                    'status_invoice' => $request->status_invoice,
                ]);

            return response()->json([
                'message' => 'A assinatura foi atualizada com sucesso!',
                'data' => Signature::find($id),
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
    public function deleteSignature($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da assinatura', 'code' => 400], 400);

        try {
            $signatureExist = Signature::where('id', $id)
                ->exists();

            if (!$signatureExist) return response()->json(['message' => 'O ID informado não é de uma assinatura válida', 'code' => 406], 406);

            Signature::where('id', $id)->delete();

            return response()->json([
                'message' => 'A assinatura com ID ' . $id . ' foi deletada com sucesso!',
                'data' => Signature::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar a assinatura',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->user_id) || !isset($request->description) || !isset($request->due_date) || !isset($request->amount) || !isset($request->status_invoice)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'amount' => 'required|integer',
            'status_invoice' => 'required|string|in:emitido,aguardando',
        ]);

        return $validator->fails() ? $validator : false;
    }
}
