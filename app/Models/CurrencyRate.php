<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CurrencyRate Сущность для курсов валют к USD
 *
 * @package App\Models
 * @property int $id
 * @property int $currency_id
 * @property number $exchange_rate
 * @property string $actual
 * @property Currency $currency
 */
class CurrencyRate extends Model
{
    use HasFactory;

    protected $fillable = ['currency_id', 'actual_date', 'exchange_rate'];

    /**
     * Возвращает связку с валютами
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }
}
