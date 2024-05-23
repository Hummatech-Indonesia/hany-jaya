<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasSupplier;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model implements HasUser, HasProduct, HasSupplier
{

    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'purchases';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_id', 'supplier_id','invoice_number', 'buy_price'
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

    /**
     * product
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * supplier
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
