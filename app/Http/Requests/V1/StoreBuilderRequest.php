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
                'name' => 'sometimes|required',
                'email' => 'sometimes|required|email',
                'phone' => 'sometimes|required|digits:10',
                'address' => 'sometimes|required',
                'city' => 'sometimes|required',
                'state' => 'sometimes|required|size:2',
                'postal_code'  => 'sometimes|required|digits:5'
            ];
        } else {
            return [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|digits:10',
                'address' => 'required',
                'city' => 'required',
                'state' => 'required|size:2',
                'postal_code'  => 'required|digits:5',
            ]; 
        }
    }
}
