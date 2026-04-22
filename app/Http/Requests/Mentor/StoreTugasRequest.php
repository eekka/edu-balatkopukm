<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasRequest extends FormRequest
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
            'deadline' => ['required', 'date'],
            'nilai_maksimal' => ['required', 'integer', 'min:1', 'max:1000'],
            'status' => ['required', 'in:draft,aktif,selesai'],
        ];
    }
}
