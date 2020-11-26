<?php


namespace App\Processing;

use App\Models\Transaction;

/**
 * Class Core
 * @package App\Processing
 */
class Core
{
    /**
     * @var TransactionStrategyInterface
     */
    protected $strategy;

    /**
     * Core constructor.
     * @param TransactionStrategyInterface $strategy
     */
    public function __construct(TransactionStrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    public function makeTransaction(Transaction $transaction): Transaction
    {
        return $this->strategy->execute($transaction);
    }
}
