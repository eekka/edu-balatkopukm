<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            'jadwal_hari' => ['nullable', 'in:senin,selasa,rabu,kamis,jumat,sabtu,minggu'],
            'jadwal_jam' => ['nullable', 'date_format:H:i'],
            'mentor_id' => ['required', Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'mentor'))],
            'mulai' => ['nullable', 'date'],
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
            'kapasitas' => ['required', 'integer', 'min:1'],
            'peserta_terdaftar' => ['nullable', 'integer', 'min:0'],
            'status' => ['required', 'in:aktif,draft,selesai'],
            'peserta_ids' => ['nullable', 'array'],
            'peserta_ids.*' => ['distinct', Rule::exists('users', 'id')->where(fn ($query) => $query->where('role', 'peserta'))],
        ];
    }
}
