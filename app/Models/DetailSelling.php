<?php

namespace App\Models;

use App\Base\Interfaces\HasProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailSelling extends Model implements HasProduct
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
}
