<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\InvoiceServices;
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
        dd($this->invoiceService->getInvoicesAndRecords(12, 2021));
        return view('admin.dashboard');
    }
}
