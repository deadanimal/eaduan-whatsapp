<?php

namespace App\Http\Requests\Ref\Integrity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRefIntegrityCategoryRequest extends FormRequest
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
            'code' => 'required|max:25',
            'descr' => 'required|max:150',
            'descr_en' => 'required|max:150',
            'sort' => 'required|integer|min:1|max:99',
            'status' => 'required|min:1|max:1',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'code.required' => 'Ruangan Kod diperlukan.',
            'code.max' => 'Kod mesti tidak melebihi :max aksara.',
            'descr.required'  => 'Ruangan Penerangan diperlukan.',
            'descr.max' => 'Penerangan mesti tidak melebihi :max aksara.',
            'descr_en.required'  => 'Ruangan Penerangan Inggeris diperlukan.',
            'descr_en.max' => 'Penerangan Inggeris mesti tidak melebihi :max aksara.',
            'sort.required'  => 'Ruangan Susunan diperlukan.',
            'sort.min'  => 'Ruangan Susunan mesti sekurang-kurangnya :min.',
            'sort.max' => 'Ruangan Susunan mesti tidak melebihi :max.',
            'status.required'  => 'Ruangan Status diperlukan.',
            'status.min'  => 'Ruangan Status tidak sah.',
            'status.max'  => 'Ruangan Status tidak sah.',
        ];
    }
}
