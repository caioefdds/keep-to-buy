<?php


namespace App\Http\Controllers\Auth;


use App\Http\Utils\Response;
use App\Http\Utils\UserUtils;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController
{
    public function login($credentials, $request): \Illuminate\Http\JsonResponse
    {
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $this->setSessionVariables();

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
            $this->setSessionVariables();

            return Response::success([], 'Login feito com sucesso.');
        }

        return Response::error([], 'Essas credenciais não correspondem.');
    }

    public function setSessionVariables()
    {
        $userData = User::find(Auth::id());
        $nameExhibition = UserUtils::getFirstAndLastName($userData['name']);

        Session::put('nameExhibition', $nameExhibition);
        Session::put('image', ($userData['image'] ?? null));
        Session::put('theme', ($userData['theme'] ?? 'light'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
