<?php


namespace App\Http\Utils;


use DateTime;
use Exception;
use Illuminate\Support\Facades\Log;

class DateUtils
{
    public static function stringToDate($string)
    {
        if (!empty($string)) {
            $array = explode("/", $string);

            if (count($array) == 3) {
                return $array[2] . "-" . $array[1] . "-" . $array[0];
            }

            return false;
        }

        return false;
    }

    /**
     * @param $string
     * @return false|string[] dia, mes e ano
     */
    public static function stringToArray($string)
    {
        if (!empty($string)) {
            $array = explode("/", $string);

            if (count($array) == 3) {
                return [
                    'day' => $array[0],
                    'month' => $array[1],
                    'year' => $array[2]
                ];
            }

            return false;
        }

        return false;
    }

    /**
     * @throws Exception
     */
    public static function getLastDayOfMonth($date)
    {
        $dateTime = new DateTime($date);
        $dateTime->modify('last day of this month');
        return $dateTime->format('d');
    }

    public static function dateToStringPrefixedDate($date, $month, $year)
    {
        if (!empty($date)) {
            $formattedDate = self::formatDate($date);
            $array = explode("-", $formattedDate);

            if (count($array) == 3) {
                return $array[2] . "/" . $month . "/" . $year;
            }

            return false;
        }

        return false;
    }

    public static function dateToString($date)
    {
        if (!empty($date)) {
            $formattedDate = self::formatDate($date);
            $array = explode("-", $formattedDate);

            if (count($array) == 3) {
                return $array[2] . "/" . $array[1] . "/" . $array[0];
            }

            return false;
        }

        return false;
    }

    public static function dateToArray($date)
    {
        if (!empty($date)) {
            $formattedDate = self::formatDate($date);
            $array = explode("-", $formattedDate);

            if (count($array) == 3) {
                return [
                    'day' => $array[2],
                    'month' => $array[1],
                    'year' => $array[0]
                ];
            }

            return false;
        }

        return false;
    }

    public static function getArrayFromDate($date)
    {
        if (!empty($date)) {
            $formattedDate = self::formatDate($date);
            $array = explode("-", $formattedDate);

            if (count($array) == 3) {
                return $array;
            }

            return false;
        }

        return false;
    }

    public static function validateDate($date, $format = 'Y-m-d H:i:s'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public static function formatDate($date)
    {
        try {
            $formattedDate = new DateTime($date);

            return $formattedDate->format('Y-m-d');
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @throws Exception
     */
    public static function getNextDates(string $selectedDate, int $quantity, string $addition = "+1 month"): array
    {
        $dateTime = new DateTime($selectedDate);

        $dates = [];
        $dates[0]['date'] = $dateTime->format('Y-m-d');
        $dates[0]['day'] = $dateTime->format('m');
        $dates[0]['month'] = $dateTime->format('m');
        $dates[0]['year'] = $dateTime->format('Y');

        for ($i = 1; $i < $quantity; $i++) {
            $dateTime->modify($addition);

            $dates[$i]['date'] = $dateTime->format('Y-m-d');
            $dates[$i]['day'] = $dateTime->format('d');
            $dates[$i]['month'] = $dateTime->format('m');
            $dates[$i]['year'] = $dateTime->format('Y');
        }

        return $dates;
    }
}
