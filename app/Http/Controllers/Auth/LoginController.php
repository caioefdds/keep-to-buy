<?php


namespace App\Http\Controllers\Auth;


use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController
{
    public function login($credentials, $request): \Illuminate\Http\JsonResponse
    {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Response::success([], 'Login feito com sucesso.');
        }

        return Response::error([], 'Essas credenciais não correspondem.');
    }

    public function authenticate(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return Response::success([], 'Login feito com sucesso.');
        }

        return Response::error([], 'Essas credenciais não correspondem.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
