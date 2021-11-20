<?php

namespace App\Http\Services;

use App\Models\Expense;
use App\Http\Constants\ExpenseConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ExpensesServices extends InvoiceServices
{
    /**
     * Main function call to create [Expense]
     * @param $data
     * @return bool
     */
    public function createExpense($data): bool
    {
        if ($data['type'] == ExpenseConstants::TYPE_FIXED) {
            return $this->__createFixedExpense($data);
        } elseif ($data['type'] == ExpenseConstants::TYPE_VARIABLE) {
            return $this->__createVariableExpense($data);
        }

        return false;
    }

    /**
     * Main function call to update [Expense]
     * @param $data
     * @return bool
     */
    public function updateExpense($data): bool
    {
        if ($data['type'] == ExpenseConstants::TYPE_FIXED) {
            return $this->__updateFixedExpense($data);
        } elseif ($data['type'] == ExpenseConstants::TYPE_VARIABLE) {
            return $this->__updateVariableExpense($data);
        }

        return false;
    }

    /**
     * Main function call to delete [Expense]
     * @param $id
     * @return bool
     */
    public function deleteExpense($id): bool
    {
        $expense = Expense::where([
            ["id", $id],
            ["user_id", Auth::id()],
        ])->first();

        if ($expense['type'] == ExpenseConstants::TYPE_FIXED) {
            return $this->__deleteFixedExpense($id);
        } elseif ($expense['type'] == ExpenseConstants::TYPE_VARIABLE) {
            return $this->__deleteVariableExpense($id);
        }

        return false;
    }

    /**
     * Create Fixed [Expense]
     * @param $data
     * @return bool
     */
    private function __createFixedExpense($data): bool
    {
        DB::beginTransaction();
        $expenseInsert = Expense::create($data);

        if (!$expenseInsert) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Create Variable [Expense]
     * @param $data
     * @return bool
     * @throws Throwable
     */
    private function __createVariableExpense($data): bool
    {
        DB::beginTransaction();
        $expenseInsert = Expense::create($data);

        if (!$expenseInsert) {
            DB::rollBack();
            return false;
        }

        $createInvoices = $this->createInvoices($expenseInsert);

        if (!$createInvoices) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Update Fixed [Expense]
     * @param $data
     * @return bool
     */
    private function __updateFixedExpense($data): bool
    {
        DB::beginTransaction();
        $expenseUpdate = Expense::where([
            ['id', $data['id']]
        ])->update([
            'name' => $data['name'],
            'value' => $data['value'],
            'status' => $data['status'],
            'date' => $data['date'],
        ]);

        if (!$expenseUpdate) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Update Variable [Expense]
     * @param $data
     * @return bool
     */
    private function __updateVariableExpense($data): bool
    {
        DB::beginTransaction();
        $expenseUpdate = Expense::where([
            ['id', $data['id']]
        ])->update([
            'name' => $data['name'],
            'value' => $data['value'],
            'status' => $data['status']
        ]);

        if (!$expenseUpdate) {
            DB::rollBack();
            return false;
        }

        $updateInvoices = $this->updateInvoices($data);

        if (!$updateInvoices) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Delete [Expense] by [id]
     * @param $id
     * @return bool
     */
    private function __deleteExpenseById($id): bool
    {
        $data = Expense::where([
            ["id", $id],
            ["user_id", Auth::id()],
        ])->delete();

        if (empty($data)) {
            return false;
        }

        return true;
    }

    /**
     * Delete Fixed [Expense]
     * @param $id
     * @return bool
     */
    private function __deleteFixedExpense($id): bool
    {
        DB::beginTransaction();
        $expenseDelete = $this->__deleteExpenseById($id);

        if (!$expenseDelete) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Delete Variable [Expense]
     * @param $id
     * @return bool
     */
    private function __deleteVariableExpense($id): bool
    {
        DB::beginTransaction();
        $expenseDelete = $this->__deleteExpenseById($id);

        if (!$expenseDelete) {
            DB::rollBack();
            return false;
        }
        $deleteInvoices = $this->deleteInvoices($id);

        if (!$deleteInvoices) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
