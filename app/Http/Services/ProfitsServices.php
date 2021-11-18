<?php

namespace App\Http\Services;

use App\Models\Profit;
use App\Http\Constants\ProfitConstants;
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

    private function __createFixedProfit($data)
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

    private function __createVariableProfit($data)
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
