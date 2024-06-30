<?php

namespace App\Http\Requests\Client;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
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
            'username'      => ['required', 'max:225', Rule::unique('clients', 'username')
                ->where('auction_id', auth('auction')->user()->id)],
            'phone1'        => ['nullable',  Rule::unique('clients', 'phone1')
                ->where('auction_id', auth('auction')->user()->id)],
            'phone2'        =>  ['nullable',  Rule::unique('clients', 'phone2')
                ->where('auction_id', auth('auction')->user()->id)],
            'name'          => 'nullable|string|max:255',
            'address'       => 'nullable|string',
            'area_id'       => 'nullable',
            'piece'         => 'nullable',
            'street'        => 'nullable',
            'avenue'        => 'nullable',
            'house_number'  => 'nullable',
            'note'          => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'required'        => 'هذا الحقل مطلوب',
            'username.unique'   => 'تم التسجيل بهذا الاسم من قبل',
            'phone1.unique'   => 'تم التسجيل بهذا الرقم من قبل',
            'phone2.unique'   => 'تم التسجيل بهذا الرقم من قبل'
        ];
    }
    
}
