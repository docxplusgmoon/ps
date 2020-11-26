<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Operation Сущность для операций транзакций
 *
 * @package App\Models
 */
class Operation extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'transaction_id', 'amount'];

    /**
     * Возвращает связку с транзакцией
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction()
    {
        return $this->belongsTo('App\Models\Transaction');
    }
}
