<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\ProfitConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfitsRequest;
use App\Http\Services\ProfitsServices;
use App\Http\Utils\DateUtils;
use App\Http\Utils\MoneyUtils;
use App\Http\Utils\Response;
use App\Models\Profit;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfitsController extends Controller
{
    private $__groupController;
    private $__categoryController;
    private $__profitService;

    public function __construct(
        GroupController $groupController,
        CategoryController $categoryController,
        ProfitsServices $profitService
    ) {
        $this->__groupController = $groupController;
        $this->__categoryController = $categoryController;
        $this->__profitService = $profitService;
    }

    /**
     * Retorna a página principal do Profits
     * @return Application|Factory|View
     */
    public function index()
    {
        $dataTable = $this->getAll();
        return view('pages.profits.index', compact('dataTable'));
    }

    /**
     * Retorna todos registros referentes ao usuário
     * @return mixed
     */
    public function getAll()
    {
        return Profit::where([
            ["profits.user_id", Auth::user()->id]
        ])
            ->leftJoin('categories', 'categories.id', 'profits.category_id')
            ->leftJoin('groups', 'groups.id', 'profits.group_id')
            ->select('profits.*', 'categories.name as category_name', 'groups.name as group_name')
        ->get();
    }

    /**
     * Função para criar um novo registro na profits
     * @param ProfitsRequest $request
     * @return JsonResponse
     */
    public function create(ProfitsRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['user_id'] = Auth::user()->id;
        $data['value'] = MoneyUtils::stringToFloat($data['value']);
        $data['date'] = DateUtils::stringToDate($data['date']);

        if (!(DateUtils::validateDate($data['date'], 'Y-m-d'))) {
            return Response::error([], "Data inválida.", [
                "date" => ["Insira corretamente a data."]
            ]);
        }

        if ($data['repeat'] == ProfitConstants::REPEAT_MANY_TIMES && $data['repeat_times'] < 1) {
            return Response::error([], "Operação inválida.", [
                "repeat_times" => ["O valor mínimo é 1."]
            ]);
        }

        $insert = $this->__profitService->createProfit($data);

        if ($insert) {
            return Response::success($insert, "Registro inserido com sucesso!");
        }
        return Response::error([], "Erro ao inserir registro");
    }

    /**
     * Função para atualizar um registro na profits
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
        $validated['user_id'] = Auth::user()->id;

        $insert = Profit::where([
            ['id', $validated['id']]
        ])->update($validated);

        if ($insert) {
            return Response::success($insert, "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar registro");
    }

    /**
     * Função para retornar a página de criação da profits
     * @return Application|Factory|View
     */
    public function createPage()
    {
        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('pages.profits.create', compact('categories', 'groups'));
    }

    /**
     * Função para retornar a página de edição da profits
     * @param $id
     * @return Application|Factory|View|JsonResponse
     */
    public function edit($id)
    {
        if (empty($id)) {
            return Response::error([], "Parâmetros enviados incorretamente");
        }

        $data = Profit::where([
            ["id", $id],
            ["user_id", Auth::user()->id],
        ])->first();
        $data['date'] = DateUtils::formatDate($data['date']);

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('admin.profits.create', compact('data', 'categories', 'groups'));
    }

    /**
     * Função para excluir um registro da profits
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

        $data = Profit::where([
            ["id", $validated['id']],
            ["user_id", Auth::user()->id],
        ])->delete();

        if (empty($data)) {
            return Response::error([], "Nennhum registro correspondente!");
        }

        return Response::success($data, "Registro excluído com sucesso!");
    }
}
