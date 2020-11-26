<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCurrencyRateRequest;
use App\Models\CurrencyRate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

/**
 * Class CurrencyRateController
 * @package App\Http\Controllers\Api
 */
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
