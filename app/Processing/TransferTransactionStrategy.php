<?php

namespace App\Processing;

use App\Exceptions\TransactionException;
use App\Models\Currency;
use App\Models\Operation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class TransferTransactionStrategy Class for transfer money client to client
 *
 * @package App\Processing
 */
class TransferTransactionStrategy implements TransactionStrategyInterface
{
    /**
     * @param Transaction $transaction
     * @return Transaction
     * @throws \Exception
     */
    public function execute(Transaction $transaction): Transaction
    {
        DB::beginTransaction();
        $logContext = [
            'operation'   => 'transfer',
            'sender_id'   => $transaction->sender_id,
            'receiver_id' => $transaction->receiver_id,
            'amount'      => $transaction->amount,
            'comment'     => $transaction->comment,
        ];

        try {
            if (!$transaction->save()) {
                throw new TransactionException('Couldn\'t create a transaction', $logContext);
            }

            $this->createUserOperation($transaction->sender, $transaction);
            $this->createUserOperation($transaction->receiver, $transaction);
            DB::commit();

            return $transaction;
        } catch (TransactionException $e) {
            Log::error($e->getMessage(), $e->payload);
            DB::rollBack();
            throw $e;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Create operation for user and update balance cache
     *
     * @param User $user
     * @param Transaction $transaction
     * @throws TransactionException
     */
    protected function createUserOperation(User $user, Transaction $transaction)
    {
        $amount = $this->getConvertedAmount(
            $transaction->currency,
            $user->currency,
            $transaction->amount
        );

        if ($user->id === $transaction->sender->id) {
            $amount *= -1;
        }

        if ($amount < 0 && $user->balance < abs($amount)) {
            throw new TransactionException("Insufficient funds in the account");
        }

        $logContext = [
            'operation' => 'transfer',
            'user_id'   => $user->id,
            'amount'    => $amount,
        ];
        $operation  = new Operation([
            'user_id'        => $user->id,
            'transaction_id' => $transaction->id,
            'amount'         => $amount,
        ]);

        if (!$operation->save()) {
            throw new TransactionException('Couldn\'t create a operation', $logContext);
        }

        $user->balance += $amount;

        if (!$user->save()) {
            throw new TransactionException('Couldn\'t update user balance', $logContext);
        }
    }

    /**
     *
     * @param Currency $targetCurrency
     * @param Currency $userCurrency
     * @param int $amount
     * @return false|float|int
     */
    protected function getConvertedAmount(Currency $targetCurrency, Currency $userCurrency, int $amount)
    {
        if ($targetCurrency->id !== $userCurrency->id) {
            $userRate = $userCurrency->actualRate()->exchange_rate;
            $targetRate = $targetCurrency->actualRate()->exchange_rate;
            return round($userRate * $amount / $targetRate, 4, PHP_ROUND_HALF_DOWN);
        }

        return $amount;
    }
}
