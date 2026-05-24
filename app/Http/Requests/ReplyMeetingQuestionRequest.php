<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReplyMeetingQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        if (!auth()->check()) return false;

        $role = auth()->user()->role;

        // Notulis boleh menjawab, viewer boleh membalas / klarifikasi
        return $role === 'notulis' || $role === 'viewer';
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
            'isi.required' => 'Balasan tidak boleh kosong.',
            'isi.max'      => 'Balasan maksimal 2000 karakter.',
        ];
    }
}