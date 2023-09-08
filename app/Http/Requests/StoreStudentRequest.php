<?php

namespace App\Http\Requests;

use App\LocalStudents;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
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
            'studentType' => 'bail|required',
            'idNumber' => 'bail|required|numeric|digits_between:1,5|unique:local_students,id_number|unique:foreign_students,id_number',
            'name' => 'bail|required',
            'age' => 'bail|required|numeric|digits_between:1,2|regex:/^[^.]+$/',
            'gender' => 'bail|nullable',
            'city' => 'bail|required',
            'mobileNumber' => 'bail|required|numeric|regex:/^(09)\\d{9}$/',
            'email' => 'bail|required|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix|email:rfc,dns',
            'grades' => 'bail|numeric|nullable'
        ];
    }

    public function messages(){
        return[
            'idNumber.digits_between' => 'The id number should not exceed by 5 digits',
            'age.digits_between' => 'The age shoud not exceeded by 2 digits'
        ];
    }
}