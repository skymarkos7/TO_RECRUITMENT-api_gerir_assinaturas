<?php

namespace App\Http\Controllers;

use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // GET
    public function getAllUsers()
    {
        try {
            $users = User::all();
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao realizar a consulta.',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        };

        if (count($users) == 0) {
            return response()->json([
                'message' => 'Ainda não há users inseridos.',
                'code' => 204
            ], 204);
        }

        return response()->json([
            'data' => $users,
            'code' => 200
        ], 200);
    }

    // GET
    public function getUser($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do user', 'code' => 400], 400);

        try {
            $userExist = User::where('id', $id)
                ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID informado não é de um user válido', 'code' => 406], 406);

            $users = User::find($id);

            if ($users == null) {
                return response()->json([
                    'message' => 'O user buscado não existe',
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
            'data' => $users,
            'code' => 200
        ], 200);
    }

    // POST
    public function insertUser(Request $request)
    {
        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            $userExist = User::where('mail', $request->mail)
                ->orWhere('phone', $request->phone)
                ->exists();

            if ($userExist) return response()->json(['message' => 'Já existe um usuário com o mesmo email ou telefone. :(', 'code' => 406], 406);

            $user = User::create([
                'name' => $request->name,
                'mail' => $request->mail,
                'phone' => $request->phone,
            ]);

            return response()->json([
                'message' => 'O user foi inserido com sucesso!',
                'data' => $user,
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
    public function updateUser(Request $request, $id = null)
    {
        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do user'], 400);

        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if ($this->validatorFields($request) !== false) {
            return response()->json([
                'errors' => $this->validatorFields($request)->errors(),
                'code' => 422
            ], 422);
        }

        try {
            $userExist = User::where('id', $id)
                ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID do user informado não existe', 'code' => 406], 406);

            $userDuplicate = User::where('mail', $request->mail)
                ->orWhere('phone', $request->phone)
                ->exists();

            if ($userDuplicate) return response()->json(['message' => 'O email ou telefone informados já pertencem a outro usuário', 'code' => 406], 406);

            User::where('id', $id)
                ->update([
                    'name' => $request->name,
                    'mail' => $request->mail,
                    'phone' => $request->phone,
                ]);

            return response()->json([
                'message' => 'O user foi atualizado com sucesso!',
                'data' => User::find($id),
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
    public function deleteUser($id = null)
    {
        if (!is_numeric($id)) return response()->json(['message' => 'O ID deve ser um número inteiro', 'code' => 400], 400);

        if (is_null($id)) return response()->json(['message' => 'Você esqueceu de informar o ID do user', 'code' => 400], 400);

        try {
            $userExist = User::where('id', $id)
                ->exists();

            if (!$userExist) return response()->json(['message' => 'O ID informado não é de um user válido', 'code' => 406], 406);

            User::where('id', $id)->delete();

            return response()->json([
                'message' => 'O user com ID ' . $id . ' foi deletado com sucesso!',
                'data' => user::all(),
                'code' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ocorreu um erro ao tentar deletar o user',
                'info' => $e->getMessage(),
                'code' => 500
            ], 500);
        }
    }

    function validateEmptyField($request)
    {
        if (!isset($request->mail) || !isset($request->name) || !isset($request->phone)) {
            return true;
        } else {
            return false;
        }
    }

    function validatorFields($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'mail' => 'required|email',
            'phone' => 'required|celular_com_ddd',
        ]);

        return $validator->fails() ? $validator : false;
    }
}
