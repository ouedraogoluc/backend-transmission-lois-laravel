<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StructureStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste selon ta logique d'autorisation (ex. auth()->user()->can(...))
    }

    public function rules(): array
    {
        return [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:structures,code',
        ];
    }
}
