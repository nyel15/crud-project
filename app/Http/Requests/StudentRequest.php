<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StudentRequest extends FormRequest
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
        $name = $this->name;
        $mobile_number = $this->mobile_number;
        return [
            'student_type' => [
                'bail',
                'required'
            ],
            'id_number' => [
                'bail', 
                'required', 
                'numeric', 
                'digits_between:1,5', 
                Rule::unique('local_students', 'id_number')->ignore($this->id),
                Rule::unique('foreign_students', 'id_number')->ignore($this->id)
            ],
            'name' => [
                'bail', 
                'required',
                Rule::unique('local_students')->where(function ($query) use($name, $mobile_number) {
                    return $query->where('name', $name)->where('mobile_number', $mobile_number);
                    })->ignore($this->id),
                Rule::unique('foreign_students')->where(function ($query) use($name, $mobile_number) {
                    return $query->where('name', $name)->where('mobile_number', $mobile_number);
                    })->ignore($this->id)
            ],
            'age' => [
                'bail',
                'required',
                'numeric',
                'digits_between:1,2',
                'regex:/^[^.]+$/'
            ],
            'gender' => [
                'bail',
                'nullable'
            ],
            'city' => [
                'bail',
                'required'
            ],
            'mobile_number' => [
                'bail',
                'required',
                'numeric',
                'regex:/^(09)\\d{9}$/',
                Rule::unique('local_students')->where(function ($query) use($name, $mobile_number) {
                    return $query->where('name', $name)->where('mobile_number', $mobile_number);
                    })->ignore($this->id),
                Rule::unique('foreign_students')->where(function ($query) use($name, $mobile_number) {
                    return $query->where('name', $name)->where('mobile_number', $mobile_number);
                    })->ignore($this->id)
            ],
            'email' => [
                'bail',
                'required',
                'regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
                'email:rfc,dns'
            ],
            'grades' => [
                'bail',
                'numeric',
                'nullable',
                'min:60',
                'max:100'
            ] 
        ];
    }

    public function messages(){
        return[
            'id_number.digits_between' => 'The id number should not exceed by 5 digits',
            'age.digits_between' => 'The age shoud not exceeded by 2 digits',
            'mobile_number.regex' => 'The mobile number must start with 09 and exactly 11 digits'
        ];
    }
}