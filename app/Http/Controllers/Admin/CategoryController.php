<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Retorna a página principal do Categories
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Retorna todos registros referentes ao usuário
     * @return mixed
     */
    public function getAll()
    {
        return Category::where([
            ["user_id", Auth::user()->id]
        ])->get();
    }

    /**
     * Função para criar um novo registro na categories
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

        $insert = Category::create($validated);

        if ($insert) {
            return Response::success($insert, "Registro inserido com sucesso!");
        }
        return Response::error([], "Erro ao inserir registro");
    }

    /**
     * Função para atualizar um registro na categories
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

        $insert = Category::where([
            ['id', $validated['id']]
        ])->update($validated);

        if ($insert) {
            return Response::success($insert, "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar registro");
    }

    /**
     * Função para retornar a página de criação da categories
     * @return Application|Factory|View
     */
    public function createPage()
    {
        return view('admin.categories.create');
    }

    /**
     * Função para retornar a página de edição da categories
     * @param $id
     * @return Application|Factory|View|JsonResponse
     */
    public function edit($id)
    {
        if (empty($id)) {
            return Response::error([], "Parâmetros enviados incorretamente");
        }

        $data = Category::where([
            ["id", $id],
            ["user_id", Auth::user()->id],
        ])->first();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return view('admin.categories.create', compact('data'));
    }

    /**
     * Função para excluir um registro da categories
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

        $data = Category::where([
            ["id", $validated['id']],
            ["user_id", Auth::user()->id],
        ])->delete();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return Response::success($data, "Registro excluído com sucesso!");
    }
}
