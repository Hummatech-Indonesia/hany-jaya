<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outlet extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'outlets';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'store_id', 'address'
    ];
}
