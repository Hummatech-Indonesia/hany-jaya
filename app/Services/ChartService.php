<?php

namespace App\Services;

use App\Helpers\FormatMonth;

class ChartService
{
    public function chartSellingYear(mixed $data): array
    {
        $array = [];
        $years = FormatMonth::tahun();

        foreach($years as $year){
            try{ $array[$year]; }catch(\Throwable $th){ $array[$year] = 0;  }
        }
        foreach ($data as $item){
            try{ 
                $array[$item["year"]] = (int)$item["total_amount_price"];
            }catch(\Throwable $th){  }
        }  
        return $array;
    }

    public function chartSellingMonth(array $data): array
    {
        $array = [];
        $months = FormatMonth::bulan();

        foreach($months as $month){
            try{ $array[$month]; }catch(\Throwable $th){ $array[$month] = 0;  }
        }   
        foreach ($data as $item){
            try{ 
                $array[$months[$item["month"]]] = (int)$item["total_amount_price"];
            }catch(\Throwable $th){  }
        }
        return $array;
    }

    public function chartSellingDay(array $data, int $year, int $month): array
    {
        $array = [];
        $days = FormatMonth::tanggal($month, $year);
        
        foreach($days as $day){
            try{ $array[$day]; }catch(\Throwable $th){ $array[$day] = 0;  }
        }
        foreach ($data as $item){
            if($item["date"] == $days[$item["date"] - 1]){
                $array[$item["date"]] = (int)$item["total_amount_price"];
            }
        }
        return $array;
    }
    
}