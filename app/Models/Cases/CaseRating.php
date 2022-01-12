<?php

namespace App\Models\Cases;

use App\EAduan;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CaseRating
 * @package App\Models\Cases
 */
class CaseRating extends Model
{
    use EAduan;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'case_number',
        'name',
        'ic_number',
        'telephone_number',
        'email',
        'answer1',
        'answer2',
        'answer3',
        'answer4',
        'feedback',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'answer1' => 'required',
        'answer2' => 'required',
        'answer3' => 'required',
        'answer4' => 'required',
    ];
}
