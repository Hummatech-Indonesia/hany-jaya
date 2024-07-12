<?php

namespace App\Models;

use App\Base\Interfaces\HasCategory;
use App\Base\Interfaces\HasDetailSellings;
use App\Base\Interfaces\HasOutlet;
use App\Base\Interfaces\HasProductUnits;
use App\Base\Interfaces\HasSupplier;
use App\Base\Interfaces\HasSupplierProducts;
use App\Base\Interfaces\HasUnit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements HasSupplierProducts, HasCategory, HasUnit, HasProductUnits, HasDetailSellings
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'outlet_id', 'category_id', 'code', 'name', 'quantity', 'unit_id', 'image'
    ];

    /**
     * supplierProducts
     *
     * @return HasMany
     */
    public function supplierProducts(): HasMany
    {
        return $this->hasMany(SupplierProduct::class);
    }

    public function detailSellings(): HasMany
    {
        return $this->hasmany(DetailSelling::class);
    }

    /**
     * category
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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

    /**
     * productUnits
     *
     * @return HasMany
     */
    public function productUnits(): HasMany
    {
        return $this->hasMany(ProductUnit::class);
    }

    /**
     * product has many purchases
     *
     * @return HasMany
     */
    public function detailPurchases(): HasMany
    {
        return $this->hasMany(DetailPurchase::class);
    }
}
