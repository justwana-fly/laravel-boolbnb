<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'title' => 'required|max:255',
            'description' => 'nullable',
            'created' => 'required|date_format:Y-m-d',
            'categories' => 'required|max:255',
            'image_url' => 'nullable|image',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Field attribute is needed.',
            'title.max' => 'Field attribute should not have more than 255 characters.',
            'title.min' => 'Field attribute should have a minimum of 3 characters.',
            'description.max' => 'Field attribute should not have more than 255 characters.',
            'created.required' => 'Field attribute is needed.',
            'created.date_format' => 'Field attribute needs to be a valid date.',
            'categories.required' => 'Field attribute is needed.',
            'categories.max' => 'Field attribute should not have more than 255 characters.',
            'technologies.required' => 'Field attribute is needed.',
            
        ];
    }
}