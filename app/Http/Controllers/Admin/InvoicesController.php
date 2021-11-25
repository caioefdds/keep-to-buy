<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\InvoiceServices;
use App\Http\Services\ProfitsServices;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class InvoicesController extends Controller
{
    /**
     * Retorna a página principal do Categories
     * @return Application|Factory|View
     */

    private $__invoiceService;

    public function __construct(
        InvoiceServices $invoiceService
    ) {
        $this->__invoiceService = $invoiceService;
    }
    public function index()
    {

        return view('admin.categories.index');
    }

}
