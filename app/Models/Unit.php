<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'units';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'unit_id');
    }

    public function productUnit()
    {
        return $this->belongsTo(ProductUnit::class, 'id', 'unit_id');
    }
}
