<?php

namespace App\Processing;

use App\Models\Currency;
use App\Models\Transaction;
use App\Models\User;

/**
 * Interface StrategyInterface
 * @package App\Processing
 */
interface TransactionStrategyInterface
{
    public function execute(Transaction $transaction): Transaction;
}
