<?php

namespace App\Http\Requests\PublicCaseRating;

use App\Models\Cases\CaseRating;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRatingRequest extends FormRequest
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
        return CaseRating::$rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'answer1.required' => 'Sila pilih Jawapan untuk soalan 1.',
            'answer2.required' => 'Sila pilih Jawapan untuk soalan 2.',
            'answer3.required' => 'Sila pilih Jawapan untuk soalan 3.',
            'answer4.required' => 'Sila pilih Jawapan untuk soalan 4.',
        ];
    }
}
