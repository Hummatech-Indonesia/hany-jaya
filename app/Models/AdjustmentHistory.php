<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'new_stock',
        'old_stock',
        'note'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
