<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency Сущность для валют
 *
 * @package App\Models
 * @property int $id
 * @property string $code
 * @property string $name
 * @property CurrencyRate $actualRate
 */
class Currency extends Model
{
    use HasFactory;

    /**
     * Возвращает связку к курсам валюты к USD
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rates()
    {
        return $this->hasMany('App\Models\CurrencyRate');
    }

    /**
     * @return CurrencyRate
     */
    public function actualRate()
    {
        return $this->rates()->where('actual_date', '=', date('Y-m-d'))->first();
    }
}
