<?php

namespace App\Http\Requests\AuctionStage;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'        => 'nullable|string',
            'start_time'  => 'required',
            'end_time'    => 'nullable',
        ];
    }
}
