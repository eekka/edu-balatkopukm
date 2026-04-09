<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'program_id' => ['required', 'exists:programs,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'mentor_id' => ['required', 'exists:users,id'],
            'mulai' => ['nullable', 'date'],
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'peserta_terdaftar' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:aktif,draft,selesai'],
            'peserta_ids' => ['array'],
            'peserta_ids.*' => ['exists:users,id'],
        ];
    }
}
