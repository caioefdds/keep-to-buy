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
     * Render da view [profits.index]
     * @return Application|Factory|View
     */
    public function index()
    {
        $dataTable = $this->treatInfo($this->getAll());
        return view('pages.profits.index', compact('dataTable'));
    }

    /**
     * Render da view [profits.create]
     * @return Application|Factory|View
     */
    public function createPage()
    {
        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('pages.profits.create', compact('categories', 'groups'));
    }


    /**
     * Render da view [profits.edit]
     * @param $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        if (empty($id)) {
            return view('livewire.error500');
        }
        $result = $this->get($id);

        if (empty($result)) {
            return view('livewire.error500');
        }

        $result['value'] = MoneyUtils::floatToString($result['value']);
        $result['date'] = DateUtils::dateToString($result['date']);

        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('pages.profits.edit', compact('result', 'categories', 'groups'));
    }

    /**
     * Consulta [Profit] por [id]
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Profit::where([
            ["profits.id", $id],
            ["profits.user_id", Auth::id()]
        ])
            ->leftJoin('categories', 'categories.id', 'profits.category_id')
            ->leftJoin('groups', 'groups.id', 'profits.group_id')
            ->select('profits.*', 'categories.name as category_name', 'groups.name as group_name')
        ->first();
    }

    /**
     * Consulta a todos os registros [Profit]
     * @return mixed
     */
    public function getAll()
    {
        return Profit::where([
            ["profits.user_id", Auth::id()]
        ])
            ->leftJoin('categories', 'categories.id', 'profits.category_id')
            ->leftJoin('groups', 'groups.id', 'profits.group_id')
            ->select('profits.*', 'categories.name as category_name', 'groups.name as group_name')
        ->get();
    }

    /**
     * Formata info contida em um array
     * @param $data
     * @return array
     */
    public function treatInfo($data): array
    {
        if (empty($data)) {
            return [];
        }

        $result = [];
        foreach ($data as $key => $item) {
            $result[$key] = $item;
            $result[$key]['value'] = MoneyUtils::floatToString($item['value']);
            $result[$key]['date'] = DateUtils::dateToString($item['date']);
            $result[$key]['status'] = ($item['date'] == 1) ? "PAGO" : "PENDENTE";
            $result[$key]['repeat'] = ($item['repeat']) ? "SIM" : "NÃO";
        }

        return $result;
    }

    /**
     * Insere registros do [Profits] e [ProfitRecords]
     * @param ProfitsRequest $request
     * @return JsonResponse
     */
    public function create(ProfitsRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['user_id'] = Auth::id();
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
     * Atualiza registros do [Profits] e [ProfitRecords]
     * @param ProfitsRequest $request
     * @return JsonResponse
     */
    public function update(ProfitsRequest $request): JsonResponse
    {
        $data = $request->all();

        $data['user_id'] = Auth::id();
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

        $update = $this->__profitService->updateProfit($data);

        if ($update) {
            return Response::success([], "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar o registro");
    }

    /**
     * Remove registros da [Profits] e [ProfitRecords]
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

        $delete = $this->__profitService->deleteProfit($validated['id']);

        if (!$delete) {
            return Response::error([], "Erro ao excluir registro!");
        }

        return Response::success([], "Registro excluído com sucesso!");
    }
}
