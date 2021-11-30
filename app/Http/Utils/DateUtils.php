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
    public static function validateBirthDate($date): bool
    {
        $currentDate = self::dateToArray(self::getCurrentDate());
        $birthDate = self::dateToArray($date);

        if ($birthDate['year'] >= $currentDate['year']) {
            return false;
        }

        return true;
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
        $currentDateTime = new DateTime("$year-$month-01");

        $day = $currentDateTime->format('d');
        $month = $currentDateTime->format('m');
        $year = $currentDateTime->format('Y');
        $lastDayOfMonth = $currentDateTime->format('t');

        if ($day > $lastDayOfMonth) {
            return "$lastDayOfMonth/$month/$year";
        }

        return "$day/$month/$year";
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

    public static function getCurrentDate(): string
    {
        $dateTime = new DateTime('now');
        return $dateTime->format('Y-m-d');
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
        $day = $dateTime->format('d');
        $month = $dateTime->format('m');
        $year = $dateTime->format('Y');

        $dates[0]['date'] = $dateTime->format('Y-m-d');
        $dates[0]['day'] = $day;
        $dates[0]['month'] = $month;
        $dates[0]['year'] = $year;

        for ($i = 1; $i < $quantity; $i++) {
            if ($month >= 12) {
                $year++;
                $month = 1;
            } else {
                $month++;
            }
            $currentDateTime = new DateTime("$year-$month-01");
            $lastDayOfMonth = $currentDateTime->format('t');
            $monthString = ($month < 10) ? "0$month" : $month;

            if ($day > $lastDayOfMonth) {
                $dates[$i]['date'] = "$year-$monthString-$lastDayOfMonth";
                $dates[$i]['day'] = "$lastDayOfMonth";
                $dates[$i]['month'] = "$monthString";
                $dates[$i]['year'] = "$year";
                continue;
            }

            $dates[$i]['date'] = "$year-$monthString-$day";
            $dates[$i]['day'] = "$day";
            $dates[$i]['month'] = "$monthString";
            $dates[$i]['year'] = "$year";
        }

        return $dates;
    }
}
