<?php

namespace App\Models;

use App\Base\Interfaces\HasBuyer;
use App\Base\Interfaces\HasPurchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model implements HasBuyer, HasPurchase
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'debts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'buyer_id', 'purchase_id', 'nominal'
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

    /**
     * purchase
     *
     * @return BelongsTo
     */
    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class);
    }
}
