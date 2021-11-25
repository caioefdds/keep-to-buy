<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Models\Expense;
use App\Http\Constants\ExpenseConstants;
use App\Models\InvoiceItems;
use App\Models\Invoices;
use App\Models\ProfitRecords;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceServices
{

    public function getInvoicesAndRecords($month, $year): array
    {
        $dateStart = "$year-$month-01 00:00:00";
        $dateEnd = "$year-$month-31 00:00:00";

        $profitFixed = ProfitRecordsServices::getProfitRecordFixedByDate($dateStart);
        $profitVariable = ProfitRecordsServices::getProfitRecordVariableByDate($dateStart, $dateEnd);
        $expenseFixed = self::getInvoiceFixedByDate($dateStart);
        $expenseVariable = self::getInvoiceVariableByDate($dateStart, $dateEnd);

        return $this->__getCompleteList($profitFixed, $profitVariable, $expenseFixed, $expenseVariable);
    }

    private function __getCompleteList($profitFixed, $profitVariable, $expenseFixed, $expenseVariable)
    {
        $dataProfitFixed = [];
        $dataExpenseFixed = [];
        $dataProfitVariable = [];
        $dataExpenseVariable = [];

        foreach ($profitFixed as $key => $value) {
            $dataProfitFixed[$key]['name'] = $value['name'];
            $dataProfitFixed[$key]['date'] = $value['date'];
            $dataProfitFixed[$key]['value'] = $value['value'];
            $dataProfitFixed[$key]['type'] = $value['type'];
            $dataProfitFixed[$key]['repeat'] = $value['repeat'];
            $dataProfitFixed[$key]['profit_record_item_id'] = $value['profit_record_item_id'];
            $dataProfitFixed[$key]['profit_record_item_status'] = $value['profit_record_item_status'];
        }

        foreach ($profitVariable as $key => $value) {
            $dataProfitVariable[$key]['name'] = $value['name'];
            $dataProfitVariable[$key]['date'] = $value['date'];
            $dataProfitVariable[$key]['value'] = $value['value'];
            $dataProfitVariable[$key]['type'] = $value['type'];
            $dataProfitVariable[$key]['repeat'] = $value['repeat'];
            $dataProfitVariable[$key]['profit_record_item_id'] = $value['profit_record_item_id'];
            $dataProfitVariable[$key]['profit_record_item_status'] = $value['profit_record_item_status'];
        }

        foreach ($expenseFixed as $key => $value) {
            $dataExpenseFixed[$key]['name'] = $value['name'];
            $dataExpenseFixed[$key]['date'] = $value['date'];
            $dataExpenseFixed[$key]['value'] = $value['value'];
            $dataExpenseFixed[$key]['type'] = $value['type'];
            $dataExpenseFixed[$key]['repeat'] = $value['repeat'];
            $dataExpenseFixed[$key]['invoice_item_id'] = $value['invoice_item_id'];
            $dataExpenseFixed[$key]['invoice_item_status'] = $value['invoice_item_status'];
        }

        foreach ($expenseVariable as $key => $value) {
            $dataExpenseVariable[$key]['name'] = $value['name'];
            $dataExpenseVariable[$key]['date'] = $value['date'];
            $dataExpenseVariable[$key]['value'] = $value['value'];
            $dataExpenseVariable[$key]['type'] = $value['type'];
            $dataExpenseVariable[$key]['repeat'] = $value['repeat'];
            $dataExpenseVariable[$key]['invoice_item_id'] = $value['invoice_item_id'];
            $dataExpenseVariable[$key]['invoice_item_status'] = $value['invoice_item_status'];
        }

        $profitArray = array_merge($dataProfitFixed, $dataProfitVariable);
        $expenseArray = array_merge($dataExpenseFixed, $dataExpenseVariable);

        return (array_merge($profitArray, $expenseArray));
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

    public static function getInvoiceFixedByDate($dateStart)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['ex.type', 1],
            ['ex.date', '<=', $dateStart],
            ['ex.deleted_at', null],
        ])
            ->leftJoin('expenses as ex', 'users.id', '=', 'ex.user_id')
            ->leftJoin('invoice_items as in_i', 'ex.id', '=', 'in_i.expense_id')
            ->select(
                'ex.name as name', 'ex.date', 'in_i.id as invoice_item_id', 'ex.value', 'ex.type', 'ex.repeat',
                DB::raw("(
                    CASE WHEN in_i.status = 1 THEN 1 ELSE 2
                END) as invoice_item_status")
            )
            ->get();
    }

    public static function getInvoiceVariableByDate($dateStart, $dateEnd)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['ex.type', 2],
        ])
            ->leftJoin('invoices as in', 'in.user_id', '=', 'users.id')
            ->leftJoin('invoice_items as in_i', 'in.id', '=', 'in_i.invoice_id')
            ->leftJoin('expenses as ex', 'in_i.expense_id', '=', 'ex.id')
            ->whereBetween('in_i.date', [$dateStart, $dateEnd])
            ->select(
                'ex.name as name', 'in_i.status as invoice_item_status', 'in_i.id as invoice_item_id',
                'ex.type', 'in_i.value', 'ex.repeat', 'in_i.date'
            )
            ->get();
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
