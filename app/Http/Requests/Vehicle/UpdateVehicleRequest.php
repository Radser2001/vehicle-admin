<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'make' => ['string', 'max:255'],
            'model' => ['string', 'max:255'],
            'year' => ['integer', 'digits:4'],
            'condition' => ['integer'],
            'category' => ['string', 'max:255'],
            'mileage' => ['integer'],
            'fuel_type' => ['string', 'max:255'],
            'price' => ['numeric', 'between:0,9999999.99'],
        ];
    }
}
