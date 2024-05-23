<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPurchase extends Model
{
    use HasFactory;
    protected $table = 'detail_purchases';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'purchase_id', 'product_id', 'product_unit_id', 'quantity', 'buy_price_per_unit', 'buy_price'
    ];
}
