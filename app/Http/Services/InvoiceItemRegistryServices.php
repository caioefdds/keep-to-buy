<?php

namespace App\Http\Services;

use App\Http\Constants\InvoiceConstants;
use App\Http\Utils\DateUtils;
use App\Http\Constants\ExpenseConstants;
use App\Http\Utils\MoneyUtils;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceItemRegistryServices extends  InvoiceServices
{
    public function editSingleRegistry($oldData, $newData)
    {
        dd($oldData, $newData);
    }

    public function editPendingRegistry($oldData, $newData)
    {
        dd($oldData, $newData);
    }

    public function editAllRegistry($oldData, $newData)
    {
        dd($oldData, $newData);
    }

    public function deleteSingleRegistry($formData, $editData)
    {
    }

    public function deletePendingRegistry($formData, $editData)
    {
    }

    public function deleteAllRegistry($formData, $editData)
    {
    }
}
