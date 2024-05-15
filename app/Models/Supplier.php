<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
