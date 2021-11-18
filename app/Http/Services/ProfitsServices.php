<?php

namespace App\Http\Services;

use App\Models\Profit;
use App\Http\Constants\ProfitConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitsServices extends ProfitRecordsServices
{
    public function createProfit($data)
    {
        if ($data['type'] == ProfitConstants::TYPE_FIXED) {
            return $this->__createFixedProfit($data);
        } elseif ($data['type'] == ProfitConstants::TYPE_VARIABLE) {
            return $this->__createVariableProfit($data);
        }

        return false;
    }

    public function deleteProfit($id): bool
    {
        $profit = Profit::where([
            ["id", $id],
            ["user_id", Auth::id()],
        ])->first();

        if ($profit['type'] == ProfitConstants::TYPE_FIXED) {
            return $this->__deleteFixedProfit($id);
        } elseif ($profit['type'] == ProfitConstants::TYPE_VARIABLE) {
            return $this->__deleteVariableProfit($id);
        }

        return false;
    }

    private function __deleteProfitById($id): bool
    {
        $data = Profit::where([
            ["id", $id],
            ["user_id", Auth::id()],
        ])->delete();

        if (empty($data)) {
            return false;
        }

        return true;
    }

    private function __deleteFixedProfit($id): bool
    {
        DB::beginTransaction();
        $profitDelete = $this->__deleteProfitById($id);

        if (!$profitDelete) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    private function __deleteVariableProfit($id): bool
    {
        DB::beginTransaction();
        $profitDelete = $this->__deleteProfitById($id);

        if (!$profitDelete) {
            DB::rollBack();
            return false;
        }
        $deleteProfitRecords = $this->deleteProfitRecords($id);

        if (!$deleteProfitRecords) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    private function __createFixedProfit($data): bool
    {
        DB::beginTransaction();
        $profitInsert = Profit::create($data);

        if (!$profitInsert) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    private function __createVariableProfit($data): bool
    {
        DB::beginTransaction();
        $profitInsert = Profit::create($data);

        if (!$profitInsert) {
            DB::rollBack();
            return false;
        }

        $createProfitRecords = $this->createProfitRecords($profitInsert);

        if (!$createProfitRecords) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
