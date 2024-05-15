<?php

namespace App\Models;

use App\Base\Interfaces\HasSupplierProducts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements HasSupplierProducts
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'outlet_id', 'category_id', 'unit_id', 'code', 'name', 'quantity', 'selling_price', 'image'
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
}
