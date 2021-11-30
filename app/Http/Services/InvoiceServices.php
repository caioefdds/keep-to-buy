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

class InvoiceServices
{
    private $invoiceRegistryServices;

    public function __construct(InvoiceItemRegistryServices $invoiceRegistryServices)
    {
        $this->invoiceRegistryServices = $invoiceRegistryServices;
    }

    public function getInvoicesAndRecords($month, $year): array
    {
        if ($month < 10) {
            $month = "0" . $month;
        }
        $dateStart = "$year-$month-01";
        $dateEnd = "$year-$month-". DateUtils::getLastDayOfMonth($dateStart);

        $profitFixed = ProfitRecordsServices::getProfitRecordFixedByDate($dateStart, $dateEnd);
        $profitVariable = ProfitRecordsServices::getProfitRecordVariableByDate($dateStart, $dateEnd);
        $expenseFixed = self::getInvoiceFixedByDate($dateStart, $dateEnd);
        $expenseVariable = self::getInvoiceVariableByDate($dateStart, $dateEnd);

        return $this->__getCompleteList($profitFixed, $profitVariable, $expenseFixed, $expenseVariable, $month, $year);
    }

    private function __getCompleteList($profitFixed, $profitVariable, $expenseFixed, $expenseVariable, $month, $year)
    {
        $dataProfitFixed = [];
        $dataExpenseFixed = [];
        $dataProfitVariable = [];
        $dataExpenseVariable = [];

        foreach ($profitFixed as $key => $value) {
            $dataProfitFixed[$key]['record_type'] = InvoiceConstants::RECORD_TYPE_PROFIT;
            $dataProfitFixed[$key]['name'] = $value['name'];
            $dataProfitFixed[$key]['status'] = $value['profit_record_item_status'];
            $dataProfitFixed[$key]['date'] = DateUtils::dateToStringPrefixedDate($value['date'], $month, $year);
            $dataProfitFixed[$key]['value'] = MoneyUtils::floatToString($value['value']);
            $dataProfitFixed[$key]['type'] = $value['type'];
            $dataProfitFixed[$key]['repeat'] = $value['repeat'];
            $dataProfitFixed[$key]['profit_id'] = $value['profit_id'];
            $dataProfitFixed[$key]['profit_record_item_id'] = $value['profit_record_item_id'];
        }

        foreach ($profitVariable as $key => $value) {
            $dataProfitVariable[$key]['record_type'] = InvoiceConstants::RECORD_TYPE_PROFIT;
            $dataProfitVariable[$key]['name'] = $value['name'];
            $dataProfitVariable[$key]['status'] = $value['profit_record_item_status'];
            $dataProfitVariable[$key]['date'] = DateUtils::dateToString($value['date']);
            $dataProfitVariable[$key]['value'] = MoneyUtils::floatToString($value['value']);
            $dataProfitVariable[$key]['type'] = $value['type'];
            $dataProfitVariable[$key]['repeat'] = $value['repeat'];
            $dataProfitVariable[$key]['profit_id'] = $value['profit_id'];
            $dataProfitVariable[$key]['profit_record_item_id'] = $value['profit_record_item_id'];
        }

        foreach ($expenseFixed as $key => $value) {
            $dataExpenseFixed[$key]['record_type'] = InvoiceConstants::RECORD_TYPE_EXPENSE;
            $dataExpenseFixed[$key]['name'] = $value['name'];
            $dataExpenseFixed[$key]['status'] = $value['invoice_item_status'];
            $dataExpenseFixed[$key]['date'] = DateUtils::dateToStringPrefixedDate($value['date'], $month, $year);
            $dataExpenseFixed[$key]['value'] = MoneyUtils::floatToString($value['value']);
            $dataExpenseFixed[$key]['type'] = $value['type'];
            $dataExpenseFixed[$key]['repeat'] = $value['repeat'];
            $dataExpenseFixed[$key]['expense_id'] = $value['expense_id'];;
            $dataExpenseFixed[$key]['invoice_item_id'] = $value['invoice_item_id'];
        }

        foreach ($expenseVariable as $key => $value) {
            $dataExpenseVariable[$key]['record_type'] = InvoiceConstants::RECORD_TYPE_EXPENSE;
            $dataExpenseVariable[$key]['name'] = $value['name'];
            $dataExpenseVariable[$key]['status'] = $value['invoice_item_status'];
            $dataExpenseVariable[$key]['date'] = DateUtils::dateToString($value['date']);
            $dataExpenseVariable[$key]['value'] = MoneyUtils::floatToString($value['value']);
            $dataExpenseVariable[$key]['type'] = $value['type'];
            $dataExpenseVariable[$key]['repeat'] = $value['repeat'];
            $dataExpenseVariable[$key]['expense_id'] = $value['expense_id'];
            $dataExpenseVariable[$key]['invoice_item_id'] = $value['invoice_item_id'];
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

    public static function getInvoiceFixedByDate($dateStart, $dateEnd)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['ex.type', 1],
            ['ex.date', '<=', $dateEnd],
            ['ex.deleted_at', null],
            ['invoice_items.deleted_at', null],
        ])
            ->leftJoin('expenses as ex', 'users.id', '=', 'ex.user_id')
            ->leftJoin('invoice_items', function ($join) use ($dateStart, $dateEnd) {
                $join->on('ex.id', '=', 'invoice_items.expense_id')
                    ->where('invoice_items.date', '>=', $dateStart)
                    ->where('invoice_items.date', '<=', $dateEnd);
            })
            ->select(
                'ex.date', 'invoice_items.id as invoice_item_id', 'ex.type', 'ex.repeat', 'ex.id as expense_id',
                DB::raw("(CASE WHEN invoice_items.status = 1 THEN 1 ELSE 2 END) as invoice_item_status"),
                DB::raw("(CASE WHEN invoice_items.value != ex.value THEN invoice_items.value ELSE ex.value END) as value"),
                DB::raw("(CASE WHEN invoice_items.name != ex.name THEN invoice_items.name ELSE ex.name END) as name"),
            )
            ->get();
    }

    public static function getInvoiceVariableByDate($dateStart, $dateEnd)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['ex.type', 2],
            ['in_i.date', '>=', $dateStart],
            ['in_i.date', '<=', $dateEnd],
            ['in_i.deleted_at', null],
        ])
            ->leftJoin('invoices as in', 'in.user_id', '=', 'users.id')
            ->leftJoin('invoice_items as in_i', 'in.id', '=', 'in_i.invoice_id')
            ->leftJoin('expenses as ex', 'in_i.expense_id', '=', 'ex.id')
            ->select(
                'ex.name as name', 'in_i.status as invoice_item_status', 'in_i.id as invoice_item_id', 'ex.id as expense_id',
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
     * Get existent [ExpenseRecord]
     * @param $month
     * @param $year
     * @return mixed
     */
    protected function __getExistentInvoiceItemDate($expense_id, $month, $year)
    {
        return InvoiceItems::where([
            ['invoices.user_id', '=', Auth::id()],
            ['invoices.year', $year],
            ['invoices.month', $month],
            ['invoice_items.expense_id', $expense_id],
        ])->join('invoices', 'invoices.id', '=', 'invoice_items.invoice_id')
            ->first();
    }

    /**
     * Get existent [InvoiceItems]
     * @param $expenseData
     * @param $invoiceData
     * @return mixed
     */
    protected function __getExistentInvoiceItems($expenseData, $invoiceData)
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
    protected function insertInvoicesByDate($month, $year)
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
    protected function insertInvoiceItems($expenseData, $invoiceData, $date)
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

    public function payInvoice($data)
    {
        $date = DateUtils::stringToArray($data['date']);
        if (empty($data['invoice_item_id'])) {
            $existentInvoice = $this->__getExistentInvoice($date['month'], $date['year']);

            if (empty($existentInvoice)) {
                $existentInvoice = $this->insertInvoicesByDate($date['month'], $date['year']);
            }

            $existentInvoiceItem = $this->__getExistentInvoiceItemDate($data['expense_id'], $date['month'], $date['year']);

            if (empty($existentInvoiceItem)) {
                return $this->payNotCreatedInvoiceItem($data, $existentInvoice['id']);
            }

            return $this->payCreatedInvoiceItem($existentInvoice['id']);
        } else {
            return $this->payCreatedInvoiceItem($data['invoice_item_id']);
        }
    }

    public function refundInvoice($data)
    {
        $date = DateUtils::stringToArray($data['date']);

        if (empty($data['invoice_item_id'])) {
            $existentInvoice = $this->__getExistentInvoice($date['month'], $date['year']);

            if (empty($existentInvoice)) {
                $existentInvoice = $this->insertInvoicesByDate($date['month'], $date['year']);
            }

            $existentInvoiceItem = $this->__getExistentInvoiceItemDate($data['expense_id'], $date['month'], $date['year']);

            if (empty($existentInvoiceItem)) {
                return $this->payNotCreatedInvoiceItem($data, $existentInvoice['id'], 2);
            }

            return $this->payCreatedInvoiceItem($existentInvoiceItem['id'], 2);
        } else {
            return $this->payCreatedInvoiceItem($data['invoice_item_id'], 2);
        }
    }

    private function payNotCreatedInvoiceItem($data, $invoice_id, $status = 1)
    {
        $date = DateUtils::stringToDate($data['date']);
        $value = MoneyUtils::stringToFloat($data['value']);

        return InvoiceItems::create([
            'invoice_id' => $invoice_id,
            'user_id' => Auth::id(),
            'expense_id' => $data['expense_id'],
            'name' => $data['name'],
            'description' => '',
            'value' => $value,
            'date' => "$date",
            'status' => $status
        ]);
    }

    private function payCreatedInvoiceItem($invoice_item_id, $status = 1)
    {
        return InvoiceItems::where([
            ['id', $invoice_item_id],
        ])->update([
            'status' => $status
        ]);
    }

    public function editRegistryInvoiceItem($formData, $editData)
    {
        if ($formData['typeAction'] == 1) {
            return $this->invoiceRegistryServices->editSingleRegistry($editData, $formData);
        } elseif ($formData['typeAction'] == 2) {
            return $this->invoiceRegistryServices->editPendingRegistry($editData, $formData);
        } elseif ($formData['typeAction'] == 3) {
            return $this->invoiceRegistryServices->editAllRegistry($editData, $formData);
        } else {
            return false;
        }
    }

    public function deleteRegistryInvoiceItem($deleteData, $typeActionDelete)
    {
        if ($typeActionDelete == 1) {
            return $this->invoiceRegistryServices->deleteSingleRegistry($deleteData);
        } elseif ($typeActionDelete == 2) {
            return $this->invoiceRegistryServices->deletePendingRegistry($deleteData);
        } elseif ($typeActionDelete == 3) {
            return $this->invoiceRegistryServices->deleteAllRegistry($deleteData);
        } else {
            return false;
        }
    }
}
