<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\TransactionException;
use App\Http\Requests\DepositTransactionRequest;
use App\Http\Requests\TransferTransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Processing\Core;
use App\Processing\DepositTransactionStrategy;
use App\Processing\TransferTransactionStrategy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class TransactionController
 * @package App\Http\Controllers\Api
 */
class TransactionController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Deposit money to user balance
     *
     * @param DepositTransactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deposit(DepositTransactionRequest $request)
    {
        $data = $request->validated();

        try {
            $processing  = new Core(new DepositTransactionStrategy());
            $transaction = new Transaction([
                'type'        => Transaction::TYPE_DEPOSIT,
                'receiver_id' => $data['user_id'],
                'amount'      => $data['amount'],
                'currency_id' => User::find($data['user_id'])->currency_id,
                'comment'     => $data['comment'],
            ]);

            $transaction = $processing->makeTransaction($transaction);
        } catch (TransactionException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $transaction,
        ]);
    }

    /**
     * Transfer money from sender to receiver
     *
     * @param TransferTransactionRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function transfer(TransferTransactionRequest $request)
    {
        $data = $request->validated();

        try {
            $processing  = new Core(new TransferTransactionStrategy());
            $transaction = new Transaction([
                'type'        => Transaction::TYPE_TRANSFER,
                'sender_id'   => $data['sender_id'],
                'receiver_id' => $data['receiver_id'],
                'amount'      => $data['amount'],
                'currency_id' => $data['currency_id'],
                'comment'     => $data['comment'],
            ]);

            if (!in_array($transaction->currency_id, [$transaction->receiver->currency_id, $transaction->sender->currency_id])) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Field currency_id must be same value as currency of sender or receiver',
                ], 422);
            }

            $transaction = $processing->makeTransaction($transaction);

        } catch (TransactionException $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $transaction,
        ]);
    }
}
