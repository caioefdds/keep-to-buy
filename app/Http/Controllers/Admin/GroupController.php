<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use App\Models\Group;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupController extends Controller
{
    /**
     * Retorna a página principal do Groups
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.groups.index');
    }

    /**
     * Retorna todos registros referentes ao usuário
     * @return mixed
     */
    public function getAll()
    {
        return Group::where([
            ["user_id", Auth::user()->id]
        ])->get();
    }

    /**
     * Função para criar um novo registro na groups
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        if (empty($request)) {
            return Response::error([], 'Dados incorretos.', [], 400);
        }

        $validated = $request->validate([
            'name' => 'required',
            'description' => ''
        ], [
            'required' => "O campo :attribute é obrigatório"
        ]);

        $validated['user_id'] = Auth::user()->id;

        $insert = Group::create($validated);

        if ($insert) {
            return Response::success($insert, "Registro inserido com sucesso!");
        }
        return Response::error([], "Erro ao inserir registro");
    }

    /**
     * Função para atualizar um registro na groups
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        if (empty($request)) {
            return Response::error([], 'Dados incorretos.', [], 400);
        }

        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => ''
        ], [
            'required' => "O campo :attribute é obrigatório"
        ]);

        $validated['user_id'] = Auth::user()->id;

        $insert = Group::where([
            ['id', $validated['id']]
        ])->update($validated);

        if ($insert) {
            return Response::success($insert, "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar registro");
    }

    /**
     * Função para retornar a página de criação da groups
     * @return Application|Factory|View
     */
    public function createPage()
    {
        return view('admin.groups.create');
    }

    /**
     * Função para retornar a página de edição da groups
     * @param $id
     * @return Application|Factory|View|JsonResponse
     */
    public function edit($id)
    {
        if (empty($id)) {
            return Response::error([], "Parâmetros enviados incorretamente");
        }

        $data = Group::where([
            ["id", $id],
            ["user_id", Auth::user()->id],
        ])->first();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return view('admin.groups.create', compact('data'));
    }

    /**
     * Função para excluir um registro da groups
     * @param Request $request
     * @return JsonResponse
     */
    public function delete(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'id' => 'required',
        ], [
            'required' => "O :attribute é obrigatório"
        ]);

        $data = Group::where([
            ["id", $validated['id']],
            ["user_id", Auth::user()->id],
        ])->delete();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return Response::success($data, "Registro excluído com sucesso!");
    }
}
