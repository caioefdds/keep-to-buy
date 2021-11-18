<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Models\Profit;
use App\Http\Constants\ProfitConstants;
use App\Models\ProfitRecordItems;
use App\Models\ProfitRecords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitRecordsServices
{
    protected function createProfitRecords($profitData): bool
    {
        $profitData['repeat_times'] = ($profitData['repeat'] == ProfitConstants::REPEAT_ONCE) ? 1 : $profitData['repeat_times'];

        $profitRecordDates = DateUtils::getNextDates($profitData['date'], $profitData['repeat_times']);

        foreach ($profitRecordDates as $date) {
            $profitRecordData = $this->insertProfitRecordsByDate($date['month'], $date['year']);
            if (!$profitRecordData) {
                return false;
            }
            $profitRecordItemData = $this->insertProfitRecordItems($profitData, $profitRecordData, $date['date']);

            if (!$profitRecordItemData) {
                return false;
            }
        }

        return true;
    }

    protected function deleteProfitRecords($profit_id): bool
    {
        $profitRecordsDelete = ProfitRecordItems::where([
            ["user_id", Auth::id()],
            ["profit_id", $profit_id],
        ])->delete();

        if (empty($profitRecordsDelete)) {
            return false;
        }

        return true;
    }

    private function insertProfitRecordsByDate($month, $year)
    {
        $getExistent = $this->__getExistentProfitRecord($month, $year);

        if (empty($getExistent)) {
            $create = ProfitRecords::create([
                'user_id' => Auth::id(),
                'month' => $month,
                'year' => $year
            ]);

            if (!$create) {
                return false;
            }

            $getExistent = $this->__getExistentProfitRecord($month, $year);
        }

        return $getExistent;
    }

    private function __getExistentProfitRecord($month, $year)
    {
        return ProfitRecords::where([
            ['user_id', '=', Auth::id()],
            ['year', $year],
            ['month', $month]
        ])->first();
    }

    private function __getExistentProfitRecordItems($profitData, $profitRecordData)
    {
        return ProfitRecordItems::where([
            ['user_id', '=', Auth::id()],
            ['profit_record_id', '=', $profitRecordData['id']],
            ['profit_id', $profitData['id']]
        ])->first();
    }

    private function insertProfitRecordItems($profitData, $profitRecordData, $date)
    {
        $getExistent = $this->__getExistentProfitRecordItems($profitData, $profitRecordData);

        if (empty($getExistent)) {
            $create = ProfitRecordItems::create([
                'user_id' => Auth::id(),
                'name' => $profitData['name'],
                'status' => $profitData['status'],
                'value' => $profitData['value'],
                'date' => $date,
                'profit_id' => $profitData['id'],
                'profit_record_id' => $profitRecordData['id'],
            ]);

            if (!$create) {
                return false;
            }

            $getExistent = $this->__getExistentProfitRecordItems($profitData, $profitRecordData);
        }

        return $getExistent;
    }

    private function updateProfitRecordItems($profitData, $profitRecordData)
    {
//        $getExistent = ProfitRecords::where([
//            ['user_id', '=', Auth::id()],
//            ['year', $year],
//            ['month', $month]
//        ])->first();
//
//        if (empty($getExistent)) {
//            $create = ProfitRecords::create([
//                'user_id' => Auth::id(),
//                'month' => $month,
//                'year' => $year
//            ]);
//
//            if (!$create) {
//                return false;
//            }
//
//            $getExistent = ProfitRecords::where([
//                ['user_id', '=', Auth::id()],
//                ['year', $year],
//                ['month', $month]
//            ])->first();
//        }
//
//        dd($getExistent);
    }
}
