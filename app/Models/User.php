<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property int $city_id
 * @property int $currency_id
 * @property number $balance
 *
 * @property City $city
 * @property Currency $currency
 */
class User extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'city_id', 'currency_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency');
    }

}
