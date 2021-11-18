<?php


namespace App\Http\Controllers\Auth;


use App\Http\Utils\DateUtils;
use App\Http\Constants\UserConstants;
use App\Http\Utils\Response;
use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends LoginController
{
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'password2' => 'required',
        ], [
            'required' => "O campo :attribute é obrigatório"
        ]);

        if ($validated['password'] != $validated['password2']) {
            return Response::error([], 'Erro ao realizar o cadastro', [
                "password" => "As senhas não coincidem.",
                "password2" => "As senhas não coincidem."
            ]);
        }

        $checkEmail = User::where([
            ['email', $validated['email']]
        ])->first();

        if (!empty($checkEmail)) {
            return Response::error([], 'Erro ao realizar o cadastro', [
                "email" => "O e-mail já possui cadastrado."
            ]);
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'type' => UserConstants::COMMON_USER,
            'status' => UserConstants::STATUS_PENDING
        ];

        $userCreate = User::create($data);

        if ($userCreate) {
            $this->login([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ], $request);

            return Response::success([], "Usuário criado com sucesso");
        }
        return Response::error([], "Erro ao criar usuário, certifique-se que os dados estão corretos.");
    }
}
