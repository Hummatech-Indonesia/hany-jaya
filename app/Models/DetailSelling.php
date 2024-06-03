<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSelling extends Model
{
    use HasFactory;
    protected $table = 'detail_sellings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'selling_id', 'product_id', 'product_unit_id', 'quantity', 'selling_price'
    ];
}
