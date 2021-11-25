<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Models\Expense;
use App\Http\Constants\ExpenseConstants;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceServices
{

    public function getInvoicesAndRecords()
    {
        
    }
    /**
     * Main function call to create [Invoices]
     * @param $expenseData
     * @return bool
     * @throws Throwable
     */
    protected function createInvoices($expenseData): bool
    {
        $expenseData['repeat_times'] = ($expenseData['repeat'] == ExpenseConstants::REPEAT_ONCE) ? 1 : $expenseData['repeat_times'];

        $invoiceDates = DateUtils::getNextDates($expenseData['date'], $expenseData['repeat_times']);

        foreach ($invoiceDates as $date) {
            $invoiceData = $this->insertInvoicesByDate($date['month'], $date['year']);
            if (!$invoiceData) {
                return false;
            }
            $invoiceItemsData = $this->insertInvoiceItems($expenseData, $invoiceData, $date['date']);

            if (!$invoiceItemsData) {
                return false;
            }
        }

        return true;
    }

    /**
     * Update [InvoiceItems]
     * @param $expenseData
     * @return bool
     */
    protected function updateInvoices($expenseData): bool
    {
        $update = InvoiceItems::where([
            'user_id' => Auth::id(),
            'expense_id' => $expenseData['id']
        ])->update([
            'name' => $expenseData['name'],
            'value' => $expenseData['value'],
            'status' => $expenseData['status'],
        ]);

        if (!$update) {
            return false;
        }

        return true;
    }

    /**
     * Delete [InvoiceItems]
     * @param $expense_id
     * @return bool
     */
    protected function deleteInvoices($expense_id): bool
    {
        $invoicesDelete = InvoiceItems::where([
            ["user_id", Auth::id()],
            ["expense_id", $expense_id],
        ])->delete();

        if (empty($invoicesDelete)) {
            return false;
        }

        return true;
    }

    /**
     * Get existent [ExpenseRecord]
     * @param $month
     * @param $year
     * @return mixed
     */
    private function __getExistentInvoice($month, $year)
    {
        return Invoices::where([
            ['user_id', '=', Auth::id()],
            ['year', $year],
            ['month', $month]
        ])->first();
    }

    /**
     * Get existent [InvoiceItems]
     * @param $expenseData
     * @param $invoiceData
     * @return mixed
     */
    private function __getExistentInvoiceItems($expenseData, $invoiceData)
    {
        return InvoiceItems::where([
            ['user_id', '=', Auth::id()],
            ['invoice_id', '=', $invoiceData['id']],
            ['expense_id', $expenseData['id']]
        ])->first();
    }

    /**
     * Insert [Invoices] by [date]
     * @param $month | month number
     * @param $year | year number
     * @return bool
     */
    private function insertInvoicesByDate($month, $year)
    {
        $getExistent = $this->__getExistentInvoice($month, $year);

        if (empty($getExistent)) {
            $create = Invoices::create([
                'user_id' => Auth::id(),
                'month' => $month,
                'year' => $year
            ]);

            if (!$create) {
                return false;
            }

            $getExistent = $this->__getExistentInvoice($month, $year);
        }

        return $getExistent;
    }

    /**
     * Insert [InvoiceItems]
     * @param $expenseData
     * @param $invoiceData
     * @param $date
     * @return false|mixed
     */
    private function insertInvoiceItems($expenseData, $invoiceData, $date)
    {
        $getExistent = $this->__getExistentInvoiceItems($expenseData, $invoiceData);

        if (empty($getExistent)) {
            $create = InvoiceItems::create([
                'user_id' => Auth::id(),
                'name' => $expenseData['name'],
                'status' => $expenseData['status'],
                'value' => $expenseData['value'],
                'date' => $date,
                'expense_id' => $expenseData['id'],
                'invoice_id' => $invoiceData['id'],
            ]);

            if (!$create) {
                return false;
            }

            $getExistent = $this->__getExistentInvoiceItems($expenseData, $invoiceData);
        }

        return $getExistent;
    }
}
