<?php

namespace App\Models;

use App\Base\Interfaces\HasDetailSellings;
use App\Base\Interfaces\HasProduct;
use App\Base\Interfaces\HasProducts;
use App\Base\Interfaces\HasSellings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model implements HasProduct, HasProducts, HasDetailSellings
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'categories';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name'
    ];

    /**
     * Get the product that owns the Category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    /**
     * Method detailSellings
     *
     * @return HasMany
     */
    public function detailSellings(): HasMany
    {
        return $this->hasMany(DetailSelling::class);
    }

    /**
     * Method products
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
