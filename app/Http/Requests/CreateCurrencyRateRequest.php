<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Class CreateCurrencyRequest Request for create CurrencyRate
 *
 * @package App\Http\Requests
 */
class CreateCurrencyRateRequest extends BaseAPIRequest
{
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'currency_id'   => 'required|exists:currencies,id',
            'actual_date'   => [
                'bail',
                'required',
                'date_format:Y-m-d',
                Rule::unique('currency_rates')->where(function ($query) {
                    return $query->where('actual_date', $this->input('actual_date'))
                        ->where('currency_id', $this->input('currency_id'));
                })
            ],
            'exchange_rate' => 'required|numeric',
        ];
    }
}
