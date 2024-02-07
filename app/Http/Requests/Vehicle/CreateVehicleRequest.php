<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class CreateVehicleRequest extends FormRequest
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
            'make' => ['nullable', 'string'],
            'model' => ['nullable', 'string'],
            'year' => ['nullable', 'integer'],
            'condition' => ['nullable', 'integer'],
            'category' => ['nullable', 'string'],
            'mileage' => ['nullable', 'integer'],
            'fuel_type' => ['nullable', 'string'],
            'price' => ['nullable', 'numeric', 'min:0'],
        ];
    }
}
