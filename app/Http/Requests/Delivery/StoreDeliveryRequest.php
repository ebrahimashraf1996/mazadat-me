<?php

namespace App\Http\Requests\Delivery;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeliveryRequest extends FormRequest
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
            'name'      => ['required', 'max:225', Rule::unique('deliveries', 'name')
                ->where('auction_id', auth('auction')->user()->id)],
            'phone1'        => ['nullable',  Rule::unique('deliveries', 'phone1')
                ->where('auction_id', auth('auction')->user()->id)],
            'phone2'        =>  ['nullable',  Rule::unique('deliveries', 'phone2')
                ->where('auction_id', auth('auction')->user()->id)],
           'email'          =>   [ 'required ',  'email ' ,'max:255', Rule::unique('deliveries', 'email')
                ->where('auction_id', auth('auction')->user()->id)],
           'password'       => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'required'        => 'هذا الحقل مطلوب',
            'name.unique'     => 'تم التسجيل بهذا الاسم من قبل',
            'email.unique'     => 'تم التسجيل بهذا الايميل من قبل',
            'phone1.unique'   => 'تم التسجيل بهذا الرقم من قبل',
            'phone2.unique'   => 'تم التسجيل بهذا الرقم من قبل',
            'password.min'    => 'كلمة السر لا تقل عن 8 احرف',
        ];
    }
    
}
