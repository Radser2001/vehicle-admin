<?php

namespace App\Http\Requests\VehicleCategory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleCategoryRequest extends FormRequest
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
            // 'code' => ['required', 'string', 'unique:car_models,code,' . $this->id],
            'name' => ['required', 'string', 'max:255'],
        ];
    }
}
