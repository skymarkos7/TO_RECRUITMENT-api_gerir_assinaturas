<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AssinaturaController extends Controller
{
    // GET
    public function getAllAssinaturas()
    {
        try {
            $assinaturas = Assinatura::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($assinaturas) == 0) {
            return response()->json([
                'message' => 'Ainda não há assinaturas inseridas.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $assinaturas,
            'code' => 200
        ], 200);
    }

    // GET
    public function getAssinatura($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da assinatura', 'code' => 400], 400);

        try {
            $assinaturaExist = Assinatura::where('id', $id)
                ->exists();

            if (!$assinaturaExist) return response()->json(['message' => 'O ID informado não é de uma assinatura válida', 'code' => 406], 406);

            $assinaturas = Assinatura::find($id);

            if ($assinaturas == null) {
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
            'data' => $assinaturas,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertAssinaturas(Request $request)
    {
        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: user_id, descrição, vencimento e valor são obrigatórios',
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

            $assinatura = Assinatura::create([
                'user_id' => $request->user_id,
                'descricao' => $request->descricao,
                'vencimento' => $request->vencimento,
                'valor' => $request->valor,
                'status_fatura' => $request->status_fatura,
            ]);

            return response()->json([
                'message' => 'Assinatura inserida com sucesso',
                'data' => $assinatura,
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
    public function updateAssinatura(Request $request, $id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validateEmptyField($request)) return response()->json([
            'message' => 'os campos: user_id, descricao, vencimento, valor, e status_fatura são obrigatórios',
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

            $assinaturaExist = Assinatura::where('id', $id)
                ->exists();

            if (!$assinaturaExist) return response()->json(['message' => 'O ID da assinatura informada na URL não existe', 'code' => 406], 406);

            $userExist = user::where('id', $request->user_id)
                ->exists();

            if (!$userExist)
                return response()->json(['message' => 'O user_id informado não é um código válido, favor informe um ID de user válido', 'code' => 406], 406);

            Assinatura::where('id', $id)
                ->update([
                    'user_id' => $request->user_id,
                    'descricao' => $request->descricao,
                    'vencimento' => $request->vencimento,
                    'valor' => $request->valor,
                    'status_fatura' => $request->status_fatura,
                ]);

            return response()->json([
                'message' => 'A assinatura foi atualizada com sucesso!',
                'data' => Assinatura::find($id),
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
    public function deleteAssinatura($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID da assinatura', 'code' => 400], 400);

        try {
            $assinaturaExist = Assinatura::where('id', $id)
                ->exists();

            if (!$assinaturaExist) return response()->json(['message' => 'O ID informado não é de uma assinatura válida', 'code' => 406], 406);

            Assinatura::where('id', $id)->delete();

            return response()->json([
                'message' => 'A assinatura com ID ' . $id . ' foi deletada com sucesso!',
                'data' => Assinatura::all(),
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
        if (!isset($request->user_id) || !isset($request->descricao) || !isset($request->vencimento) || !isset($request->valor) || !isset($request->status_fatura)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|integer',
            'descricao' => 'required|string',
            'vencimento' => 'required|date',
            'valor' => 'required|integer',
            'status_fatura' => 'required|string|in:emitido,aguardando',
        ]);

        return $validator->fails() ? $validator : false;
    }
}
