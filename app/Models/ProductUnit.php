<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductUnit extends Model implements HasProduct, HasUnit
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'product_units';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'product_id', 'unit_id', 'quantity_in_small_unit', 'selling_price', 'is_delete', 'deleted_at'
    ];

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
     * unit
     *
     * @return BelongsTo
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
