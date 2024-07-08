<?php

namespace App\Helpers;

use App\Models\User;
use Carbon\Carbon;

class FormatMonth
{
    public static function tahun(): array
    {
        $user = User::orderBy('created_at','ASC')->first();
        $start_year = Carbon::parse($user->created_at)->format('Y');
        $now = date('Y');

        $range = (int)$now - (int)$start_year;
        $array = [];
        $array[] = (int)$now;

        $start_range = (int)$now;
        for($i = 1; $i<$range; $i++){
            $start_range += 1;
            $array[] = $start_range;
        }

        return $array;
    }

    public static function bulan(): array
    {
        $month = [
            '1' => 'Januari',
            '2' => 'Februari',
            '3' => 'Maret',
            '4' => 'April',
            '5' => 'Mei',
            '6' => 'Juni',
            '7' => 'Juli',
            '8' => 'Agustus',
            '9' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];

        return $month;
    }

    public static function tanggal(int $month, int $tahun):array
    {
        $kalender = cal_days_in_month(CAL_GREGORIAN, $month, $tahun);
        $tanggal = [];
        for($i = 0; $i<$kalender; $i++)
        {
            $tanggal[] = $i;
        }
        return $tanggal;
    }
}
