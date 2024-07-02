<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasProductUnit;
use App\Base\Interfaces\HasPurchase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPurchase extends Model implements HasProduct, HasProductUnit, HasPurchase
{
    use HasFactory;
    protected $table = 'detail_purchases';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'purchase_id', 'product_id', 'product_unit_id', 'quantity', 'buy_price_per_unit', 'buy_price'
    ];

    /**
     * Get the product that owns the DetailPurchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    /**
     * Get the productUnit that owns the DetailPurchase
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function productUnit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class);
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
