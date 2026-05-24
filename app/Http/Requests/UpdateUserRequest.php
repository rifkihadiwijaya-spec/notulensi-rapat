<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'admin';
    }

    public function rules(): array
    {
        // Ambil user id dari route parameter
        $userId = $this->route('user')?->id;

        return [
            'name'     => 'required|string|max:255',
            'username' => "required|string|max:255|unique:users,username,{$userId}|alpha_dash",
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => 'required|in:admin,notulis,viewer',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'       => 'Nama wajib diisi.',
            'username.required'   => 'Username wajib diisi.',
            'username.unique'     => 'Username sudah digunakan.',
            'username.alpha_dash' => 'Username hanya boleh berisi huruf, angka, strip, dan underscore.',
            'password.min'        => 'Password minimal 8 karakter.',
            'password.confirmed'  => 'Konfirmasi password tidak cocok.',
            'role.required'       => 'Role wajib dipilih.',
            'role.in'             => 'Role tidak valid.',
        ];
    }
}