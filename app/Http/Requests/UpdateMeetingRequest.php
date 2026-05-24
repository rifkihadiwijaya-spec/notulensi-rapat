<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMeetingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'judul'          => 'required|string|max:255',
            'tanggal'        => 'required|date',
            'waktu'          => 'required',
            'lokasi'         => 'required|string|max:255',
            'jenis'          => 'nullable|string|max:255',
            'topik'          => 'nullable|string|max:5000',
            'partisipan'     => 'nullable|string|max:5000',
            'notulensi'      => 'nullable|string',
            'status'         => 'required|in:scheduled,completed',
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
            'status.in'               => 'Status hanya boleh: scheduled atau completed.',
            'dokumentasi.*.image'     => 'File harus berupa gambar.',
            'dokumentasi.*.mimes'     => 'Format gambar harus jpg, jpeg, png, atau webp.',
            'dokumentasi.*.max'       => 'Ukuran gambar maksimal 3MB.',
            'surat_undangan.mimes'    => 'Surat undangan harus berupa file PDF.',
            'surat_undangan.max'      => 'Ukuran file PDF maksimal 5 MB.',
        ];
    }
}