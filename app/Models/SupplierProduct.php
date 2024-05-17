<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasSupplier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierProduct extends Model implements HasSupplier, HasProduct
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'supplier_products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'supplier_id', 'product_id'
    ];

    /**
     * supplier
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
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
}
