<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Class TransferTransactionRequest Request for deposit user account
 *
 * @package App\Http\Requests
 */
class TransferTransactionRequest extends BaseAPIRequest
{
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sender_id'   => 'bail|required|numeric|exists:users,id',
            'receiver_id' => 'bail|required|numeric|different:sender_id|exists:users,id',
            'currency_id' => 'required|integer',
            'amount'      => 'required|integer|min:1',
            'comment'     => 'required|string|min:5',
        ];
    }
}
