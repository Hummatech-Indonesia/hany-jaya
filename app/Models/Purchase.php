<?php

namespace App\Models;

use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model implements HasUser
{

    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'purchases';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_id', 'product_id', 'supplier_id', 'quantity', 'buy_price'
    ];

    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
