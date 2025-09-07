<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust based on your auth logic
    }

    public function rules(): array
    {
        return [
            'structure_id' => 'required|exists:structures,id',
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:services,code,' . $this->service->id,
        ];
    }
}
