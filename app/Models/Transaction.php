<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction Сущность для транзакций
 *
 * @package App\Models
 * @property int $id
 * @property int $type
 * @property int $sender_id
 * @property int $receiver_id
 * @property number $amount
 * @property string $comment
 * @property int $currency_id
 *
 * @property User $sender
 * @property User $receiver
 * @property Currency $currency
 */
class Transaction extends Model
{
    use HasFactory;

    const TYPE_DEPOSIT  = 0;
    const TYPE_TRANSFER = 1;

    protected $fillable = ['type', 'receiver_id', 'amount', 'currency_id', 'sender_id', 'comment'];

    /**
     * Возвращает связку к операциям транзакции
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function operations()
    {
        return $this->hasMany('App\Model\Operation');
    }

    /**
     * Return binding with sender user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }

    /**
     * Return binding with receiver user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function receiver()
    {
        return $this->belongsTo('App\Models\User', 'receiver_id');
    }

    /**
     * Return binding with target currency
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency_id');
    }
}
