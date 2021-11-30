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

        $this->invoiceService->editRegistryInvoiceItem($formData, $editData);
    }
}
