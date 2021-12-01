<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Http\Utils\MoneyUtils;
use App\Models\Profit;
use App\Models\ProfitRecordItems;
use App\Models\ProfitRecords;
use Illuminate\Support\Facades\Auth;

class ProfitRecordRegistryServices
{
    private function __setDataUpdate($data)
    {
        return [
            'name' => $data['name'],
            'value' => MoneyUtils::stringToFloat($data['value']),
        ];
    }

    private function __getExistentProfitRecord($month, $year)
    {
        return ProfitRecords::where([
            ['user_id', Auth::id()],
            ['month', $month],
            ['year', $year],
        ])->first();
    }

    private function __getExistentProfitRecordItem($profitRecordData, $data)
    {
        return ProfitRecordItems::where([
            ['user_id', '=', Auth::id()],
            ['profit_record_id', '=', $profitRecordData['id']],
            ['profit_id', $data['profit_id']]
        ])->first();
    }

    private function __deleteProfit($id)
    {
        return Profit::find($id)->delete();
    }

    private function __updateProfit($id, $data)
    {
        return Profit::find($id)->update($data);
    }

    private function __updateProfitRecordItem($id, $data)
    {
        return ProfitRecordItems::find($id)->update($data);
    }

    private function __deleteProfitRecordItem($id)
    {
        return ProfitRecordItems::find($id)->delete();
    }

    private function __updateManyProfitRecordItem($data, $where)
    {
        return ProfitRecordItems::where($where)->update($data);
    }

    private function __deleteManyProfitRecordItem($where)
    {
        return ProfitRecordItems::where($where)->delete();
    }

    private function __getOrCreateProfitRecord($data)
    {
        $arrayDate = DateUtils::stringToArray($data['date']);
        $existentProfitRecord = $this->__getExistentProfitRecord($arrayDate['month'], $arrayDate['year']);

        if (empty($existentProfitRecord)) {
            $create = ProfitRecords::create([
                'user_id' => Auth::id(),
                'month' => $arrayDate['month'],
                'year' => $arrayDate['year']
            ]);

            if (!$create) {
                return false;
            }

            $existentProfitRecord = $this->__getExistentProfitRecord($arrayDate['month'], $arrayDate['year']);
        }

        return $existentProfitRecord;
    }

    private function __getOrCreateProfitRecordItem($data)
    {
        if (!empty($data['profit_record_item_id'])) {
            return ProfitRecordItems::find($data['profit_record_item_id']);
        }

        $existentProfitRecord = $this->__getOrCreateProfitRecord($data);
        $existentProfitRecordItem = $this->__getExistentProfitRecordItem($existentProfitRecord, $data);

        if (empty($existentProfitRecordItem)) {
            $value = MoneyUtils::stringToFloat($data['value']);
            $date = DateUtils::stringToDate($data['date']);

            $create = ProfitRecordItems::create([
                'user_id' => Auth::id(),
                'name' => $data['name'],
                'status' => $data['status'],
                'value' => $value,
                'date' => $date,
                'profit_id' => $data['profit_id'],
                'profit_record_id' => $existentProfitRecord['id'],
            ]);

            if (!$create) {
                return false;
            }

            $existentProfitRecordItem = $this->__getExistentProfitRecordItem($existentProfitRecord, $data);
        }

        return $existentProfitRecordItem;
    }

    public function editSingleRegistry($oldData, $newData)
    {
        $profitRecordData = $this->__getOrCreateProfitRecord($oldData);
        if (!$profitRecordData) {
            return false;
        }
        $profitRecordItemData = $this->__getOrCreateProfitRecordItem($oldData);
        if (!$profitRecordItemData) {
            return false;
        }

        $dataUpdate = $this->__setDataUpdate($newData);

        $update = $this->__updateProfitRecordItem($profitRecordItemData['id'], $dataUpdate);

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
            ['profit_id', $oldData['profit_id']],
            ['status', 2],
        ];
        $updateProfit = $this->__updateProfit($oldData['profit_id'], $dataUpdate);

        if (empty($updateProfit)) {
            return false;
        }

        $this->__updateManyProfitRecordItem($dataUpdate, $where);

        return true;
    }

    public function editAllRegistry($oldData, $newData)
    {
        $dataUpdate = $this->__setDataUpdate($newData);
        $where = [
            ['user_id', Auth::id()],
            ['profit_id', $oldData['profit_id']],
        ];
        $updateProfit = $this->__updateProfit($oldData['profit_id'], $dataUpdate);

        if (empty($updateProfit)) {
            return false;
        }

        $this->__updateManyProfitRecordItem($dataUpdate, $where);

        return true;
    }

    public function deleteSingleRegistry($deleteData)
    {
        $profitRecordData = $this->__getOrCreateProfitRecord($deleteData);
        if (!$profitRecordData) {
            return false;
        }
        $profitRecordItemData = $this->__getOrCreateProfitRecordItem($deleteData);
        if (!$profitRecordItemData) {
            return false;
        }

        $delete = $this->__deleteProfitRecordItem($profitRecordItemData['id']);

        if (empty($delete)) {
            return false;
        }

        return true;
    }

    public function deletePendingRegistry($deleteData)
    {
        $where = [
            ['user_id', Auth::id()],
            ['profit_id', $deleteData['profit_id']],
            ['status', 2],
        ];
        $deleteProfit = $this->__deleteProfit($deleteData['profit_id']);

        if (empty($deleteProfit)) {
            return false;
        }

        $this->__deleteManyProfitRecordItem($where);

        return true;
    }

    public function deleteAllRegistry($deleteData)
    {
        $where = [
            ['user_id', Auth::id()],
            ['profit_id', $deleteData['profit_id']],
        ];
        $deleteProfit = $this->__deleteProfit($deleteData['profit_id']);

        if (empty($deleteProfit)) {
            return false;
        }

        $this->__deleteManyProfitRecordItem($where);

        return true;
    }
}
