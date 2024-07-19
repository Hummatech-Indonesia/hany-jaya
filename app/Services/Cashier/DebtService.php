<?php

namespace App\Services\Cashier;

use App\Contracts\Interfaces\Cashier\SellingInterface;
use App\Models\Debt;
use App\Models\HistoryPayDebt;

class DebtService
{
    private SellingInterface $selling;
    public function __construct(SellingInterface $selling)
    {
        
    }

    public function checkDebtUser(mixed $debts, mixed $historyPayDebts)
    {
        $data = [];
        foreach($debts as $debt){
            $selectPaying = $historyPayDebts->where('buyer_id', $debt->buyer_id)->first();
            
            $checkDebt = ($debt->total_debt ?? 0) - ($selectPaying?->total_pay_debt ?? 0);
            $data[] = [
                "buyer_id" => $debt->buyer_id,
                "buyer_name" => $debt->buyer_name,
                "buyer_address" => $debt->buyer_address,
                "total_debt" => $debt->total_debt,
                "total_pay_debt" => $selectPaying?->total_pay_debt ?? 0,
                "nominal_after_check" => $checkDebt,
                "debt_status" => $checkDebt > 0 ? "BELUM LUNAS" : "LUNAS"
            ];
        }

        return $data;
    }
}
