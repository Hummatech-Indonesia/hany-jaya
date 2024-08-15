<?php

namespace App\Models;

use App\Base\Interfaces\HasSellings;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Buyer extends Model implements HasSellings
{
    use HasFactory;
    protected $table = 'buyers';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'address',
        'debt',
        'telp',
        'code',
        'limit_debt',
        'limit_time_debt',
        'limit_date_debt'
    ];

    /**
     * sellings
     *
     * @return HasMany
     */
    public function sellings(): HasMany
    {
        return $this->hasMany(Selling::class);
    }

    /**
     * sellings
     *
     * @return HasMany
     */
    public function payDebts(): HasMany
    {
        return $this->hasMany(HistoryPayDebt::class);
    }
}
