<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\InvoiceServices;
use App\Http\Utils\DateUtils;
use App\Http\Utils\Response;
use DateTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    private $invoiceService;

    public function __construct(InvoiceServices $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index()
    {
        $dateTime = date('Y-m-d');
        $date = DateUtils::getArrayFromDate($dateTime);
        [$dataTable, $totalProfits, $totalExpenses] = $this->getDataTableByDate($date[1], $date[0]);

        return view('pages.index', compact('dataTable', 'totalProfits', 'totalExpenses'));
    }

    public function get(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'month' => 'required',
            'year' => 'required'
        ]);

        [$data, $totalProfits, $totalExpenses] = $this->getDataTableByDate($validated['month'], $validated['year']);

        return Response::success([
            "data" => $data,
            "totalProfits" => $totalProfits,
            "totalExpenses" => $totalExpenses
        ], '', 201);
    }

    public function getDataTableByDate($month, $year): array
    {
        return $this->invoiceService->getInvoicesAndRecords($month, $year);
    }
}
