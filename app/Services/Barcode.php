<?php

namespace App\Services;

class Barcode
{
    /**
     * Число в строку со штрихкодом 13 цифр
     * Справа число, остальное ноли слева
     * 
     * @param int
     * @return string
     */
    public function int_to_barcode($number): string
    {
        $barcode = str_pad($number, 13, '0', STR_PAD_LEFT);
        
        return $barcode;
    }

    /**
     * Строку со штрихкодом 13 цифр в число
     * Преобразование к типу integer
     * 
     * @param string
     * @return int
     */
    public function barcode_to_int($string): int
    {
        $barcode = intval($string);
        
        return $barcode;
    }
}