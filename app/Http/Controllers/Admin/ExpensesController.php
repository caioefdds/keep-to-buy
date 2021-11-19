<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use App\Models\Expense;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpensesController extends Controller
{
    private $__groupController;
    private $__categoryController;

    public function __construct()
    {
        $this->__groupController = new GroupController();
        $this->__categoryController = new CategoryController();
    }

    /**
     * Retorna a página principal do Expenses
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('admin.expenses.index');
    }

    /**
     * Retorna todos registros referentes ao usuário
     * @return mixed
     */
    public function getAll()
    {
        return Expense::where([
            ["expenses.user_id", Auth::id()]
        ])
            ->leftJoin('categories', 'categories.id', 'expenses.category_id')
            ->leftJoin('groups', 'groups.id', 'expenses.group_id')
            ->select('expenses.*', 'categories.name as category_name', 'groups.name as group_name')
            ->get();
    }

    /**
     * Função para criar um novo registro na expenses
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
            'category_id' => '',
            'status' => 'required',
            'date' => 'required',
            'type' => 'required',
            'repeat' => '',
            'repeat_times' => '',
            'repeat_type' => '',
        ], [
            'required' => "O campo :attribute é obrigatório"
        ]);

        if (!(DateUtils::validateDate($validated['date'], 'Y-m-d'))) {
            return Response::error([], "Data inválida.", [
                "date" => "Insira corretamente a data."
            ]);
        }
        $validated['user_id'] = Auth::id();

        $insert = Expense::create($validated);

        if ($insert) {
            return Response::success($insert, "Registro inserido com sucesso!");
        }
        return Response::error([], "Erro ao inserir registro");
    }

    /**
     * Função para atualizar um registro na expenses
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
            'category_id' => '',
            'status' => 'required',
            'date' => 'required',
            'type' => 'required',
            'repeat' => '',
            'repeat_times' => '',
            'repeat_type' => '',
        ], [
            'required' => "O campo :attribute é obrigatório"
        ]);

        if (!(DateUtils::validateDate($validated['date'], 'Y-m-d'))) {
            return Response::error([], "Data inválida.", [
                "date" => "Insira corretamente a data."
            ]);
        }
        $validated['user_id'] = Auth::id();

        $insert = Expense::where([
            ['id', $validated['id']]
        ])->update($validated);

        if ($insert) {
            return Response::success($insert, "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar registro");
    }

    /**
     * Função para retornar a página de criação da expenses
     * @return Application|Factory|View
     */
    public function createPage()
    {
        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('admin.expenses.create', compact('categories', 'groups'));
    }

    /**
     * Função para retornar a página de edição da expenses
     * @param $id
     * @return Application|Factory|View|JsonResponse
     */
    public function edit($id)
    {
        if (empty($id)) {
            return Response::error([], "Parâmetros enviados incorretamente");
        }

        $data = Expense::where([
            ["id", $id],
            ["user_id", Auth::id()],
        ])->first();
        $data['date'] = DateUtils::formatDate($data['date']);

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('admin.expenses.create', compact('data', 'categories', 'groups'));
    }

    /**
     * Função para excluir um registro da expenses
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

        $data = Expense::where([
            ["id", $validated['id']],
            ["user_id", Auth::id()],
        ])->delete();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return Response::success($data, "Registro excluído com sucesso!");
    }
}
