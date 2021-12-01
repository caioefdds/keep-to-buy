<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Http\Utils\MoneyUtils;
use App\Models\Expense;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;

class InvoiceItemRegistryServices
{
    private function __setDataUpdate($data)
    {
        return [
            'name' => $data['name'],
            'value' => MoneyUtils::stringToFloat($data['value']),
        ];
    }

    private function __getExistentInvoice($month, $year)
    {
        return Invoices::where([
            ['user_id', Auth::id()],
            ['month', $month],
            ['year', $year],
        ])->first();
    }

    private function __getExistentInvoiceItem($invoiceData, $data)
    {
        return InvoiceItems::where([
            ['user_id', '=', Auth::id()],
            ['invoice_id', '=', $invoiceData['id']],
            ['expense_id', $data['expense_id']]
        ])->first();
    }

    private function __deleteExpense($id)
    {
        return Expense::find($id)->delete();
    }

    private function __updateExpense($id, $data)
    {
        return Expense::find($id)->update($data);
    }

    private function __updateInvoiceItem($id, $data)
    {
        return InvoiceItems::find($id)->update($data);
    }

    private function __deleteInvoiceItem($id)
    {
        return InvoiceItems::find($id)->delete();
    }

    private function __updateManyInvoiceItem($data, $where)
    {
        return InvoiceItems::where($where)->update($data);
    }

    private function __deleteManyInvoiceItem($where)
    {
        return InvoiceItems::where($where)->delete();
    }

    private function __getOrCreateInvoice($data)
    {
        $arrayDate = DateUtils::stringToArray($data['date']);
        $existentInvoice = $this->__getExistentInvoice($arrayDate['month'], $arrayDate['year']);

        if (empty($existentInvoice)) {
            $create = Invoices::create([
                'user_id' => Auth::id(),
                'month' => $arrayDate['month'],
                'year' => $arrayDate['year']
            ]);

            if (!$create) {
                return false;
            }

            $existentInvoice = $this->__getExistentInvoice($arrayDate['month'], $arrayDate['year']);
        }

        return $existentInvoice;
    }

    private function __getOrCreateInvoiceItem($data)
    {
        if (!empty($data['invoice_item_id'])) {
            return InvoiceItems::find($data['invoice_item_id']);
        }

        $existentInvoice = $this->__getOrCreateInvoice($data);
        $existentInvoiceItem = $this->__getExistentInvoiceItem($existentInvoice, $data);

        if (empty($existentInvoiceItem)) {
            $value = MoneyUtils::stringToFloat($data['value']);
            $date = DateUtils::stringToDate($data['date']);

            $create = InvoiceItems::create([
                'user_id' => Auth::id(),
                'name' => $data['name'],
                'status' => $data['status'],
                'value' => $value,
                'date' => $date,
                'expense_id' => $data['expense_id'],
                'invoice_id' => $existentInvoice['id'],
            ]);

            if (!$create) {
                return false;
            }

            $existentInvoiceItem = $this->__getExistentInvoiceItem($existentInvoice, $data);
        }

        return $existentInvoiceItem;
    }

    public function editSingleRegistry($oldData, $newData)
    {
        $invoiceData = $this->__getOrCreateInvoice($oldData);
        if (!$invoiceData) {
            return false;
        }
        $invoiceItemData = $this->__getOrCreateInvoiceItem($oldData);
        if (!$invoiceItemData) {
            return false;
        }

        $dataUpdate = $this->__setDataUpdate($newData);

        $update = $this->__updateInvoiceItem($invoiceItemData['id'], $dataUpdate);

        if (empty($update)) {
            return false;
        }

        return true;
    }

    public function editPendingRegistry($oldData, $newData)
    {
        $dataUpdate = $this->__setDataUpdate($newData);
        $where = [
            ['user_id', Auth::id()],
            ['expense_id', $oldData['expense_id']],
            ['status', 2],
        ];
        $updateExpense = $this->__updateExpense($oldData['expense_id'], $dataUpdate);

        if (empty($updateExpense)) {
            return false;
        }

        $this->__updateManyInvoiceItem($dataUpdate, $where);

        return true;
    }

    public function editAllRegistry($oldData, $newData)
    {
        $dataUpdate = $this->__setDataUpdate($newData);
        $where = [
            ['user_id', Auth::id()],
            ['expense_id', $oldData['expense_id']],
        ];
        $updateExpense = $this->__updateExpense($oldData['expense_id'], $dataUpdate);

        if (empty($updateExpense)) {
            return false;
        }

        $this->__updateManyInvoiceItem($dataUpdate, $where);

        return true;
    }

    public function deleteSingleRegistry($deleteData)
    {
        $invoiceData = $this->__getOrCreateInvoice($deleteData);
        if (!$invoiceData) {
            return false;
        }
        $invoiceItemData = $this->__getOrCreateInvoiceItem($deleteData);
        if (!$invoiceItemData) {
            return false;
        }

        $delete = $this->__deleteInvoiceItem($invoiceItemData['id']);

        if (empty($delete)) {
            return false;
        }

        return true;
    }

    public function deletePendingRegistry($deleteData)
    {
        $where = [
            ['user_id', Auth::id()],
            ['expense_id', $deleteData['expense_id']],
            ['status', 2],
        ];
        $deleteExpense = $this->__deleteExpense($deleteData['expense_id']);

        if (empty($deleteExpense)) {
            return false;
        }

        $this->__deleteManyInvoiceItem($where);

        return true;
    }

    public function deleteAllRegistry($deleteData)
    {
        $where = [
            ['user_id', Auth::id()],
            ['expense_id', $deleteData['expense_id']],
        ];
        $deleteExpense = $this->__deleteExpense($deleteData['expense_id']);

        if (empty($deleteExpense)) {
            return false;
        }

        $this->__deleteManyInvoiceItem($where);

        return true;
    }
}
