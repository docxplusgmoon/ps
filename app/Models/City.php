<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class City Сущность для городов
 *
 * @package App\Models
 */
class City extends Model
{
    use HasFactory;

    /**
     * Возвращает страну к которой пренадлежит город
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
