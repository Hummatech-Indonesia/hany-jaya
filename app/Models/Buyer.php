<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $table = 'buyers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'name', 'address', 'debt',
    ];
}
