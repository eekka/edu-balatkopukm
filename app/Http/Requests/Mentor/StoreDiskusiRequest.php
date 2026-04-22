<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;

class StoreDiskusiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'mentor';
    }

    public function rules(): array
    {
        return [
            'topik' => ['required', 'string', 'max:255'],
            'isi' => ['required', 'string'],
            'pertemuan' => ['required', 'integer', 'min:1'],
        ];
    }
}
