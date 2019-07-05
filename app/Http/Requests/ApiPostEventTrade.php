<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiPostEventTrade extends FormRequest
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
            'unit_price' => 'required|numeric|min:1',
            'units' => 'required|numeric|min:1',
            'type' => 'required|in:sell,buy',
            'wage' => 'required|numeric|min:0',
            'total_amount' => 'required|numeric|min:0',
            'status' => 'required|in:done,half,going',
            'description' => 'required|string',
            'date' => 'required|date',
            'company_id' => 'required|numeric|min:1',
        ];
    }
}
