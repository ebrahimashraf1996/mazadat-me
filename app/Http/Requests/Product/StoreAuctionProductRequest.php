<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuctionProductRequest extends FormRequest
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
                'purchase_type'               => 'required',
                'count_pieces'                => 'required|numeric',
                'price'                       => 'required|numeric',
                'notes'                       => 'sometimes|nullable',
                'code'                        => 'sometimes|nullable|unique:auction_products,code',
                'client'                      => 'required',
                'product'                     => 'required',
        ];
    }
    public function messages()
    {
        return [
             'purchase_type.required'         => 'يجب تحديد نوع الشراء',
                'count_pieces.required'       => 'يجب تحديد عدد القطع',
                'count_pieces.numeric'       => ' يجب عدد القطع ان يكون رقم',
                'price.required'              => 'يجب تحديد السعر',
                'price.numeric'              => 'يجب  السعر ان يكون رقم',
                'code.unique'                 => 'هذا الكود مستخدم من قبل',
                'code.required'               => 'يجب تحديد الكود',
                'client.required'             => 'يجب تحديد اسم العميل',
                // 'client.unique'            => 'هذا المستخدم تم خذفة من قبل اضف عميل اخر',
                'product.required'            => 'يجب تحديد اسم المنتج',
        ];
    }
}
