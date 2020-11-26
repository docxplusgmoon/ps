<?php

namespace App\Processing;


use App\Exceptions\TransactionException;
use App\Models\Currency;
use App\Models\Operation;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Class DepositStrategy Class for deposit money to client balance
 *
 * @package App\Processing
 */
class DepositTransactionStrategy implements TransactionStrategyInterface
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
            'operation' => 'deposit',
            'user_id'   => $transaction->receiver_id,
            'amount'    => $transaction->amount,
            'comment'   => $transaction->comment,
        ];

        try {
            if (!$transaction->save()) {
                throw new TransactionException('Couldn\'t create a transaction', $logContext);
            }

            $operation = new Operation([
                'user_id'        => $transaction->receiver_id,
                'transaction_id' => $transaction->id,
                'amount'         => $transaction->amount,
            ]);

            if (!$operation->save()) {
                throw new TransactionException('Couldn\'t create a operation', $logContext);
            }

            $transaction->receiver->balance += $transaction->amount;

            if (!$transaction->receiver->save()) {
                Log::error("Couldn't update user balance", $logContext);
                DB::rollBack();
            }

            DB::commit();

            return $transaction;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();
            throw $e;
        }
    }
}
