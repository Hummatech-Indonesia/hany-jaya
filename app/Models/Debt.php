<?php

namespace App\Models;

use App\Base\Interfaces\HasBuyer;
use App\Base\Interfaces\HasSelling;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Debt extends Model implements HasBuyer, HasSelling
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'debts';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'buyer_id', 'selling_id', 'nominal', 'status'
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
     * selling
     *
     * @return BelongsTo
     */
    public function selling(): BelongsTo
    {
        return $this->belongsTo(Selling::class);
    }
}
