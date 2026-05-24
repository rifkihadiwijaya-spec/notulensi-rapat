<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'viewer';
    }

    public function rules(): array
    {
        return [
            'isi' => 'required|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'isi.required' => 'Pertanyaan tidak boleh kosong.',
            'isi.max'      => 'Pertanyaan maksimal 2000 karakter.',
        ];
    }
}