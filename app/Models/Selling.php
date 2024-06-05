<?php

namespace App\Models;

use App\Base\Interfaces\HasDetailSellings;
use App\Base\Interfaces\HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Selling extends Model implements HasUser, HasDetailSellings
{
    use HasFactory;
    public $incrementing = false;
    public $keyType = 'char';
    protected $table = 'sellings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_id', 'invoice_number', 'amount_price'
    ];


    /**
     * user
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * detailSellings
     *
     * @return HasMany
     */
    public function detailSellings(): HasMany
    {
        return $this->hasMany(DetailSelling::class);
    }
}
