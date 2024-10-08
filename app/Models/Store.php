<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'stores';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name', 'logo', 'code_debt'
    ];
}
