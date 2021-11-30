<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\ProfitRecordConstants;
use App\Http\Controllers\Controller;
use App\Http\Services\ProfitRecordsServices;
use App\Http\Utils\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \Illuminate\Http\JsonResponse;

class ProfitRecordItemsController extends Controller
{
    private $profitService;

    public function __construct(ProfitRecordsServices $profitService)
    {
        $this->profitService = $profitService;
    }

    public function receive(Request $request)
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        if ($requestData['status'] == ProfitRecordConstants::STATUS_PAID) {
            $this->profitService->refundProfitRecord($requestData);

            return Response::success([], '', 201);
        } elseif ($requestData['status'] == ProfitRecordConstants::STATUS_PENDING) {
            $this->profitService->receiveProfitRecord($requestData);

            return Response::success([], '', 201);
        }
    }

    public function editRegistry(Request $request): JsonResponse
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        $formData = $requestData['formData'] ?? [];
        $editData = $requestData['editData'] ?? [];

        DB::beginTransaction();
        $edit = $this->profitService->editRegistryProfitRecordItem($formData, $editData);
        if (!$edit) {
            DB::rollBack();
            return Response::error([], 'Erro ao editar');
        }
        DB::commit();

        return Response::success('', 'Editado com sucesso', 201);
    }

    public function deleteRegistry(Request $request): JsonResponse
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        $deleteData = $requestData['deleteData'] ?? [];
        $typeActionDelete = $requestData['typeActionDelete'] ?? null;

        DB::beginTransaction();
        $delete = $this->profitService->deleteRegistryProfitRecordItem($deleteData, $typeActionDelete);
        if (!$delete) {
            DB::rollBack();
            return Response::error([], 'Erro ao deletar');
        }
        DB::commit();

        return Response::success('', 'Deletado com sucesso', 201);
    }
}
