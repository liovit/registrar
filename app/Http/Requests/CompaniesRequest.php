<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompaniesRequest extends FormRequest
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
            "title" => "required|string|min:3|max:255",
            "email" => "required|email|string|min:3|max:255",
            "web_url" => "required|url|string|min:3|max:255",
            "logo" => "min:3|max:255|file|mimes:jpeg,jpg,png,bmp"
        ];
    }



}
