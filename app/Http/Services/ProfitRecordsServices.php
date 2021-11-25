<?php

namespace App\Http\Services;

use App\Http\Utils\DateUtils;
use App\Models\Profit;
use App\Http\Constants\ProfitConstants;
use App\Models\ProfitRecordItems;
use App\Models\ProfitRecords;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class ProfitRecordsServices
{
    /**
     * Main function call to create [ProfitRecords]
     * @param $profitData
     * @return bool
     * @throws Throwable
     */
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

    /**
     * Update [ProfitRecordItems]
     * @param $profitData
     * @return bool
     */
    protected function updateProfitRecords($profitData): bool
    {
        $update = ProfitRecordItems::where([
            'user_id' => Auth::id(),
            'profit_id' => $profitData['id']
        ])->update([
            'name' => $profitData['name'],
            'value' => $profitData['value'],
            'status' => $profitData['status'],
        ]);

        if (!$update) {
            return false;
        }

        return true;
    }

    /**
     * Delete [ProfitRecordItems]
     * @param $profit_id
     * @return bool
     */
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

    /**
     * Get existent [ProfitRecord]
     * @param $month
     * @param $year
     * @return mixed
     */
    private function __getExistentProfitRecord($month, $year)
    {
        return ProfitRecords::where([
            ['user_id', '=', Auth::id()],
            ['year', $year],
            ['month', $month]
        ])->first();
    }

    public static function getProfitRecordFixedByDate($dateStart)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['p.type', 1],
            ['p.date', '<=', $dateStart],
            ['p.deleted_at', null],
        ])
            ->leftJoin('profits as p', 'users.id', '=', 'p.user_id')
            ->leftJoin('profit_record_items as pr_i', 'p.id', '=', 'pr_i.profit_id')
            ->select(
                'p.name as name', 'p.date', 'pr_i.id as profit_record_item_id', 'p.value', 'p.type', 'p.repeat',
                DB::raw("(
                    CASE WHEN pr_i.status = 1 THEN 1 ELSE 2
                END) as profit_record_item_status")
            )
            ->get();
    }

    public static function getProfitRecordVariableByDate($dateStart, $dateEnd)
    {
        return User::where([
            ['users.id', Auth::id()],
            ['p.type', 2],
        ])
            ->leftJoin('profit_records as pr', 'pr.user_id', '=', 'users.id')
            ->leftJoin('profit_record_items as pr_i', 'pr.id', '=', 'pr_i.profit_record_id')
            ->leftJoin('profits as p', 'pr_i.profit_id', '=', 'p.id')
            ->whereBetween('pr_i.date', [$dateStart, $dateEnd])
            ->select(
                'p.name as name', 'pr_i.status as profit_record_item_status', 'pr_i.id as profit_record_item_id',
                'p.type', 'pr_i.value', 'p.repeat', 'pr_i.date'
            )
            ->get();
    }

    /**
     * Get existent [ProfitRecordItem]
     * @param $profitData
     * @param $profitRecordData
     * @return mixed
     */
    private function __getExistentProfitRecordItems($profitData, $profitRecordData)
    {
        return ProfitRecordItems::where([
            ['user_id', '=', Auth::id()],
            ['profit_record_id', '=', $profitRecordData['id']],
            ['profit_id', $profitData['id']]
        ])->first();
    }

    /**
     * Insert [ProfitRecords] by [date]
     * @param $month | month number
     * @param $year | year number
     * @return bool
     */
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

    /**
     * Insert [ProfitRecordItems]
     * @param $profitData
     * @param $profitRecordData
     * @param $date
     * @return false|mixed
     */
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
}
