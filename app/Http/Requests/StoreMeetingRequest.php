<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->role === 'notulis';
    }

    public function rules(): array
    {
        return [
            'judul'          => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'waktu'          => 'required',
            'lokasi'         => 'required|string|max:255',
            'jenis'          => 'required|string|max:255',
            'topik'          => 'nullable|string|max:5000',
            'partisipan'     => 'nullable|string|max:5000',
            'notulensi'      => 'nullable|string',
            'dokumentasi'    => 'nullable|array',
            'dokumentasi.*'  => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            // ── Surat Undangan ──────────────────────────────────────
            'surat_undangan' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'          => 'Judul rapat wajib diisi.',
            'tanggal.required'        => 'Tanggal rapat wajib diisi.',
            'waktu.required'          => 'Waktu rapat wajib diisi.',
            'lokasi.required'         => 'Lokasi rapat wajib diisi.',
            'jenis.required'          => 'Jenis rapat wajib diisi.',
            'surat_undangan.mimes'    => 'Surat undangan harus berupa file PDF.',
            'surat_undangan.max'      => 'Ukuran file PDF maksimal 5 MB.',
            'dokumentasi.*.image'     => 'File harus berupa gambar.',
            'dokumentasi.*.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'dokumentasi.*.max'       => 'Ukuran gambar maksimal 3MB.',
        ];
    }
}