<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnItem extends Model
{
    use HasFactory;

    public $primaryKey = "id";
    public $incrementing = false;

    protected $guearded = [];
}
