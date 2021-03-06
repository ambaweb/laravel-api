<?php

namespace App\Http\Requests\V1;

use Illuminate\Foundation\Http\FormRequest;

class StoreBuilderRequest extends FormRequest
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
        $method = $this->method();

        if ($method == 'PATCH') {
            return [
                'email' => 'sometimes|required|email|unique:builders',
                'name' => 'sometimes|required',
                'phone' => 'sometimes|required|digits:10',
                'address' => 'sometimes|required',
                'city' => 'sometimes|required',
                'state' => 'sometimes|required|size:2',
                'postal_code'  => 'sometimes|required|digits:5',
                'is_active'  => 'sometimes|required|boolean'
            ];
        } else {
            return [
                'email' => 'required|email|unique:builders',
                'name' => 'required',
                'phone' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required|size:2',
                'postal_code'  => 'required|digits:5',
                'is_active'  => 'required|required|boolean'
            ]; 
        }
    }
}
