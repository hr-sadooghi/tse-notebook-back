<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiPostEvent extends FormRequest
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
            'type' => "required|in:text,image,file,link,trade",
            'detail_id' => "nullable|numeric|min:1",
            'description' => "required|string",
            'date' => "required|date",
            'company_id' => "required|numeric:min:1",
        ];
    }
}
