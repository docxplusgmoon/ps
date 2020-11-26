<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Class DepositTransactionRequest Request for deposit user account
 *
 * @package App\Http\Requests
 */
class DepositTransactionRequest extends BaseAPIRequest
{
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => 'bail|required|numeric|exists:users,id',
            'amount'  => 'required|integer|min:1',
            'comment' => 'required|string|min:5',
        ];
    }
}
