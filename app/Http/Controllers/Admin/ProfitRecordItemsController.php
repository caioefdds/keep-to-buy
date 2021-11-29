<?php

namespace App\Http\Controllers\Admin;

use App\Http\Constants\ProfitRecordConstants;
use App\Http\Controllers\Controller;
use App\Http\Services\ProfitRecordsServices;
use App\Http\Utils\Response;
use Illuminate\Http\Request;

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
}
