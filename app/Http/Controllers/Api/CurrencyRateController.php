<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\TransactionException;
use App\Http\Requests\CreateCurrencyRateRequest;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\DepositTransactionRequest;
use App\Http\Requests\TransferTransactionRequest;
use App\Models\CurrencyRate;
use App\Models\Transaction;
use App\Models\User;
use App\Processing\Core;
use App\Processing\DepositTransactionStrategy;
use App\Processing\TransferTransactionStrategy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class CurrencyRateController extends Controller
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Deposit money to user balance
     *
     * @param CreateCurrencyRateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(CreateCurrencyRateRequest $request)
    {
        $currencyRate = CurrencyRate::updateOrCreate($request->validated());

        return response()->json([
            'status' => 'success',
            'data'   => $currencyRate,
        ]);
    }
}
