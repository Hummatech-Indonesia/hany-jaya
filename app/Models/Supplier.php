<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'suppliers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'outlet_id', 'name', 'address'
    ];

    /**
     * Get the supplier products for the supplier.
     */
    public function supplierProducts(): HasMany
    {
        return $this->hasMany(SupplierProduct::class, 'supplier_id', 'id');
    }
}
