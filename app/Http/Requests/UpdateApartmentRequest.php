<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'rooms' => 'nullable|integer|min:1',
            'beds' => 'nullable|integer|min:1',
            'bathrooms' => 'nullable|integer|min:1',
            'square_meters' => 'nullable|integer|min:10',
            'image_cover' => 'nullable|image|max:2048',
            'address' => 'string|max:255|min:7',
            'services' => 'nullable|array|min:1',
            'services.*' => 'integer|exists:services,id',
        ];
    }
    public function messages()
    {
        return [
            'name.string' => 'Il campo nome deve essere una stringa.',
            'name.max' => 'Il campo nome non può superare i 255 caratteri.',
            
            'description.string' => 'Il campo descrizione deve essere una stringa.',
            
            'rooms.integer' => 'Il campo stanze deve essere un numero intero.',
            'rooms.min' => 'Il campo stanze deve essere almeno 1.',
            
            'beds.integer' => 'Il campo letti deve essere un numero intero.',
            'beds.min' => 'Il campo letti deve essere almeno 1.',
            
            'bathrooms.integer' => 'Il campo bagni deve essere un numero intero.',
            'bathrooms.min' => 'Il campo bagni deve essere almeno 1.',
            
            'square_meters.integer' => 'Il campo metri quadrati deve essere un numero intero.',
            'square_meters.min' => 'Il campo metri quadrati deve essere almeno 10.',
            
            'address.string' => 'Il campo indirizzo deve essere una stringa.',
            'address.max' => 'Il campo indirizzo non può superare i 255 caratteri.',
            'address.min' => 'Il campo bagni deve avere almeno 7 caratteri.',
            
            'visibility.required' => 'Il campo visibilità è obbligatorio.',
            'visibility.boolean' => 'Il campo visibilità deve essere vero o falso.',
            
            'image_cover.string' => 'Il campo immagine di copertina deve essere una stringa.',
            'image_cover.max' => 'Il campo immagine di copertina non può superare i 255 caratteri.',

            'services.min' => 'Please select at least one service.',
            'services.*.integer' => 'Each selected service must be valid.',
            'services.*.exists' => 'Each selected service must exist.',
        ];
        
    }
}
