<?php

namespace App\Http\Requests\API;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class ListGameAccountsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($this->user()->cannot('view', User::query()->find($this->input('player_id')))) {
                $validator->errors()->add('player_id', __("You're not authorized to view :player_id", ['']));
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'player_id' => 'required|exists:users,id'
        ];
    }
}
