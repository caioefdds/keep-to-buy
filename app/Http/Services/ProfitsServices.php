<?php

namespace App\Http\Services;

use App\Models\Profit;
use App\Http\Constants\ProfitConstants;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProfitsServices extends ProfitRecordsServices
{
    /**
     * Main function call to create [Profit]
     * @param $data
     * @return bool
     */
    public function createProfit($data): bool
    {
        if ($data['type'] == ProfitConstants::TYPE_FIXED) {
            return $this->__createFixedProfit($data);
        } elseif ($data['type'] == ProfitConstants::TYPE_VARIABLE) {
            return $this->__createVariableProfit($data);
        }

        return false;
    }

    /**
     * Main function call to update [Profit]
     * @param $data
     * @return bool
     */
    public function updateProfit($data): bool
    {
        if ($data['type'] == ProfitConstants::TYPE_FIXED) {
            return $this->__updateFixedProfit($data);
        } elseif ($data['type'] == ProfitConstants::TYPE_VARIABLE) {
            return $this->__updateVariableProfit($data);
        }

        return false;
    }

    /**
     * Main function call to delete [Profit]
     * @param $id
     * @return bool
     */
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

    /**
     * Create Fixed [Profit]
     * @param $data
     * @return bool
     */
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

    /**
     * Create Variable [Profit]
     * @param $data
     * @return bool
     * @throws Throwable
     */
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

    /**
     * Update Fixed [Profit]
     * @param $data
     * @return bool
     */
    private function __updateFixedProfit($data): bool
    {
        DB::beginTransaction();
        $profitUpdate = Profit::where([
            ['id', $data['id']]
        ])->update([
            'name' => $data['name'],
            'value' => $data['value'],
            'status' => $data['status'],
            'date' => $data['date'],
        ]);

        if (!$profitUpdate) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Update Variable [Profit]
     * @param $data
     * @return bool
     */
    private function __updateVariableProfit($data): bool
    {
        DB::beginTransaction();
        $profitUpdate = Profit::where([
            ['id', $data['id']]
        ])->update([
            'name' => $data['name'],
            'value' => $data['value'],
            'status' => $data['status']
        ]);

        if (!$profitUpdate) {
            DB::rollBack();
            return false;
        }

        $updateProfitRecords = $this->updateProfitRecords($data);

        if (!$updateProfitRecords) {
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    /**
     * Delete [Profit] by [id]
     * @param $id
     * @return bool
     */
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

    /**
     * Delete Fixed [Profit]
     * @param $id
     * @return bool
     */
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

    /**
     * Delete Variable [Profit]
     * @param $id
     * @return bool
     */
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
}
