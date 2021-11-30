<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ProfileRequest;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use App\Models\User;
use Carbon\Traits\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController
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
}
