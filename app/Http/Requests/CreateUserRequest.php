<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

/**
 * Class CreateUserRequest Request for create user via API
 *
 * @package App\Http\Requests
 */
class CreateUserRequest extends BaseAPIRequest
{
    /**
     * Validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'bail|required|min:3|max:255|unique:users,name',
            'country_id'  => 'required|numeric|exists:countries,id',
            'city_id'     => [
                'required',
                'numeric',
                Rule::exists('cities', 'id')->where(function ($query) {
                    $query->where('country_id', (int)$this->input('country_id'));
                })
            ],
            'currency_id' => 'required|exists:currencies,id',
        ];
    }
}
