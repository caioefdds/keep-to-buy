<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\InvoiceConstants;
use App\Http\Controllers\Controller;
use App\Http\Services\InvoiceServices;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoiceItemsController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceServices $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function pay(Request $request)
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        if ($requestData['status'] == InvoiceConstants::STATUS_PAID) {
            $this->invoiceService->refundInvoice($requestData);
            return Response::success([], '', 201);
        } elseif ($requestData['status'] == InvoiceConstants::STATUS_PENDING) {
            $this->invoiceService->payInvoice($requestData);
            return Response::success([], '', 201);
        }
    }

    public function get(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'required',
            'year' => 'required'
        ]);

        $data = $this->getDataTableByDate($validated['month'], $validated['year']);

        return Response::success($data, '', 201);
    }

    public function getDataTableByDate($month, $year): array
    {
        return $this->invoiceService->getInvoicesAndRecords($month, $year);
    }

    public function editRegistry(Request $request)
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        $formData = $requestData['formData'] ?? [];
        $editData = $requestData['editData'] ?? [];

        DB::beginTransaction();
        $edit = $this->invoiceService->editRegistryInvoiceItem($formData, $editData);
        if (!$edit) {
            DB::rollBack();
            return Response::error([], 'Erro ao editar');
        }
        DB::commit();

        return Response::success('', 'Editado com sucesso', 201);
    }

    public function deleteRegistry(Request $request)
    {
        if (empty($request->data)) {
            return Response::error([], 'Dados inválidos');
        }

        $requestData = $request->data;
        $deleteData = $requestData['deleteData'] ?? [];
        $typeActionDelete = $requestData['typeActionDelete'] ?? null;

        DB::beginTransaction();
        $delete = $this->invoiceService->deleteRegistryInvoiceItem($deleteData, $typeActionDelete);
        if (!$delete) {
            DB::rollBack();
            return Response::error([], 'Erro ao deletar');
        }
        DB::commit();

        return Response::success('', 'Deletado com sucesso', 201);
    }
}
