<?php

namespace App\Helpers;

use Carbon\Carbon;

class FormatedHelper
{
    /**
     * convert to rupiah currency
     *
     * @param float $number
     *
     * @return string
     */

    public static function rupiahCurrency(float $number): string
    {
        return "Rp " . number_format($number, 0, ',', '.');
    }

    /**
     * dateTimeFormat
     *
     * @param  mixed $dateTime
     * @return string
     */
    public static function dateTimeFormat(string $dateTime): string
    {
        $date = Carbon::parse($dateTime);
        $newFormat = $date->isoFormat('dddd, D MMMM Y');
        return $newFormat;
    }

    /**
     * return the date without the day
     *
     * @param string $dateTime
     * @return string
     */
    public static function dateFormat(string $dateTime): string
    {
        $date = Carbon::parse($dateTime);
        $newFormat = $date->isoFormat('DD MMMM Y');
        return $newFormat;
    }

    /**
     * return the time
     *
     * @param string $dateTime
     * @return string
     */
    public static function timeFormat(string $dateTime): string
    {
        $date = Carbon::parse($dateTime);
        $newFormat = $date->isoFormat('hh:mm');
        return $newFormat;
    }
}
