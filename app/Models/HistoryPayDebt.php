<?php

namespace App\Models;

use App\Base\Interfaces\HasBuyer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HistoryPayDebt extends Model implements HasBuyer
{
    use HasFactory;

    protected $table = 'history_pay_debts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'buyer_id', 'pay_debt', 'desc'
    ];


    /**
     * buyer
     *
     * @return BelongsTo
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(Buyer::class);
    }
}
