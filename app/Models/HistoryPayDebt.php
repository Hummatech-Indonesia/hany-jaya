<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryPayDebt extends Model
{
    use HasFactory;

    protected $table = 'history_pay_debts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'buyer_id', 'pay_debt'
    ];
}
