<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\ExpenseConstants;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Http\Services\ExpensesServices;
use App\Http\Utils\DateUtils;
use App\Http\Utils\MoneyUtils;
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
    private $__expenseService;

    public function __construct(
        GroupController $groupController,
        CategoryController $categoryController,
        ExpensesServices $expenseService
    ) {
        $this->__groupController = $groupController;
        $this->__categoryController = $categoryController;
        $this->__expenseService = $expenseService;
    }

    /**
     * Render da view [expenses.index]
     * @return Application|Factory|View
     */
    public function index()
    {
        $dataTable = $this->treatInfo($this->getAll());
        return view('pages.expenses.index', compact('dataTable'));
    }

    /**
     * Render da view [expenses.create]
     * @return Application|Factory|View
     */
    public function createPage()
    {
        $categories = $this->__categoryController->getAll();
        $groups = $this->__groupController->getAll();

        return view('pages.expenses.create', compact('categories', 'groups'));
    }


    /**
     * Render da view [expenses.edit]
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

        return view('pages.expenses.edit', compact('result', 'categories', 'groups'));
    }

    /**
     * Consulta [Expense] por [id]
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return Expense::where([
            ["expenses.id", $id],
            ["expenses.user_id", Auth::id()]
        ])
            ->leftJoin('categories', 'categories.id', 'expenses.category_id')
            ->leftJoin('groups', 'groups.id', 'expenses.group_id')
            ->select('expenses.*', 'categories.name as category_name', 'groups.name as group_name')
        ->first();
    }

    /**
     * Consulta a todos os registros [Expense]
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
     * Insere registros do [Expenses] e [ExpenseRecords]
     * @param ExpensesRequest $request
     * @return JsonResponse
     */
    public function create(ExpensesRequest $request): JsonResponse
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

        if ($data['repeat'] == ExpenseConstants::REPEAT_MANY_TIMES && $data['repeat_times'] < 1) {
            return Response::error([], "Operação inválida.", [
                "repeat_times" => ["O valor mínimo é 1."]
            ]);
        }

        $insert = $this->__expenseService->createExpense($data);

        if ($insert) {
            return Response::success($insert, "Registro inserido com sucesso!");
        }
        return Response::error([], "Erro ao inserir registro");
    }

    /**
     * Atualiza registros do [Expenses] e [ExpenseRecords]
     * @param ExpensesRequest $request
     * @return JsonResponse
     */
    public function update(ExpensesRequest $request): JsonResponse
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

        if ($data['repeat'] == ExpenseConstants::REPEAT_MANY_TIMES && $data['repeat_times'] < 1) {
            return Response::error([], "Operação inválida.", [
                "repeat_times" => ["O valor mínimo é 1."]
            ]);
        }

        $update = $this->__expenseService->updateExpense($data);

        if ($update) {
            return Response::success([], "Registro atualizado com sucesso!");
        }
        return Response::error([], "Erro ao atualizar o registro");
    }

    /**
     * Remove registros da [Expenses] e [ExpenseRecords]
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

        $delete = $this->__expenseService->deleteExpense($validated['id']);

        if (!$delete) {
            return Response::error([], "Erro ao excluir registro!");
        }

        return Response::success([], "Registro excluído com sucesso!");
    }
}
