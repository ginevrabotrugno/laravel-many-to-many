<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectsRequest extends FormRequest
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
            'title' => 'required|min:3|max:100',
            'start_date' => 'required',
            'status' => 'required|min:3|max:20',
            'project_url' => 'nullable|active_url',
            'technologies' => 'min:3|max:255'
        ];
    }

    public function messages(){
        return [
            'title.required' => 'Il titolo è obbligatorio.',
            'title.min' => 'Il titolo deve contenere almeno :min caratteri.',
            'title.max' => 'Il titolo non può superare i :max caratteri.',
            'start_date.required' => 'La data di inizio è obbligatoria.',
            'status.required' => 'Lo stato è obbligatorio.',
            'status.min' => 'Lo stato deve contenere almeno :min caratteri.',
            'status.max' => 'Lo stato non può superare i :max caratteri.',
            'project_url.active_url' => 'L\'URL del progetto deve essere valido.',
            'technologies.min' => 'Le tecnologie devono contenere almeno :min caratteri.',
            'technologies.max' => 'Le tecnologie non possono superare i :max caratteri.'
        ];
    }}


