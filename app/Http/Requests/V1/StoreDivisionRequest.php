<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreDivisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = $this->method();

        if ($method == 'PATCH') {
            return [
                'name' => 'sometimes|required',
                'state' => 'sometimes|required',
                'latitude' => 'sometimes|required',
                'longitude' => 'sometimes|required',
                'is_active'  => 'sometimes|required|boolean'
            ];
        } else {
            return [
                'name' => 'required|required',
                'state' => 'required|required',
                'latitude' => 'required|required',
                'longitude' => 'required|required',
                'is_active'  => 'sometimes|required|boolean'
            ]; 
        }
    }
}
