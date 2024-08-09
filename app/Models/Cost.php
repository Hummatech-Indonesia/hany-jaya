<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = 'id';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function lossCategory()
    {
        return $this->hasOne(LossCategory::class);
    }

    public function user_edit()
    {
        return $this->belongsTo(User::class, 'edited_user_id');
    }
}
