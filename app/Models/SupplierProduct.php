<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierProduct extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'supplier_products';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'supplier_id', 'product_id'
    ];
}
