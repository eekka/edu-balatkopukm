<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'mentor';
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'waktu_pengerjaan' => ['required', 'integer', 'min:5', 'max:300'],
            'nilai_maksimal' => ['required', 'integer', 'min:1', 'max:1000'],
            'mulai' => ['nullable', 'date'],
            'selesai' => ['nullable', 'date', 'after_or_equal:mulai'],
            'status' => ['required', 'in:draft,aktif,selesai'],
        ];
    }
}
