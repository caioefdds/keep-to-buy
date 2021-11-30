<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{

    public function index()
    {
        $userData = $this->get(Auth::id());

        return view('pages.profile', compact('userData'));
    }

    public function get($id)
    {
        $user = User::find($id);
        $user->birth_date = DateUtils::dateToString($user['birth_date']);

        return $user;
    }

    public function update(ProfileRequest $request)
    {
        $profileData = $request->validated();
        $birthDate = DateUtils::stringToDate($profileData['birth_date']);

        if (!(DateUtils::validateDate($birthDate, 'Y-m-d'))) {
            return Response::error([], "Data inválida.", [
                "birth_date" => ["Insira uma data válida."]
            ]);
        }

        if (!(DateUtils::validateBirthDate($birthDate))) {
            return Response::error([], "Data inválida.", [
                "birth_date" => ["Insira uma data válida."]
            ]);
        }
        $profileData['birth_date'] = $birthDate;
        $update = User::find(Auth::id())->update($profileData);

        if (!$update) {
            return Response::error([], "Erro ao atualizar.");
        }

        return Response::success([], "Perfil editado com sucesso!", 201);
    }

    public function changeTheme()
    {
        $newTheme = 'light';
        $user = User::find(Auth::id());

        if ($user['theme'] == 'light') {
            $newTheme = 'dark';
        }

        Session::forget('theme');
        Session::put('theme', $newTheme);

        return User::find(Auth::id())->update([
            'theme' => $newTheme
        ]);
    }

    public function getTheme()
    {
        if (Session::exists('theme')) {
            return Session::get('theme');
        }

        $user = User::find(Auth::id());
        return $user['theme'];
    }
}
