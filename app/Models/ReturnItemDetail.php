<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItemDetail extends Model
{
    use HasFactory;
    
    public $primaryKey = "id";
    public $incrementing = false;

    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
