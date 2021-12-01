<?php

namespace App\Http\Utils;

class UserUtils
{

    public static function getFirstAndLastName($name): string
    {
        if (empty($name)) {
            return '';
        }
        $partes = explode(' ', $name);
        $primeiroNome = array_shift($partes);
        $ultimoNome = array_pop($partes);
        return $primeiroNome . " " . $ultimoNome;
    }
}
