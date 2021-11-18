<?php

namespace App\Http\Utils;

class MoneyUtils
{
    public static function stringToFloat(string $value): float
    {
        $cleanString = preg_replace('/([^0-9\,])/i', '', $value);
        return (float)str_replace(',', '.', $cleanString);
    }
    public static function floatToString($number): string
    {
        $formattedNumber = new \NumberFormatter( 'pt_BR', \NumberFormatter::CURRENCY );
        return $formattedNumber->format($number);
    }
}
