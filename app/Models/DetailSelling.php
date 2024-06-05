<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasProductUnit;
use App\Base\Interfaces\HasProductUnits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DetailSelling extends Model implements HasProduct, HasProductUnit
{
    use HasFactory;
    protected $table = 'detail_sellings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'selling_id', 'product_id', 'product_unit_id', 'quantity', 'selling_price'
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
     * productUnit
     *
     * @return BelongsTo
     */
    public function productUnit(): BelongsTo
    {
        return $this->belongsTo(ProductUnit::class);
    }
}
