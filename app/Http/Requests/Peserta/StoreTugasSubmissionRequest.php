<?php

namespace App\Http\Requests\Peserta;

use Illuminate\Foundation\Http\FormRequest;

class StoreTugasSubmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'peserta';
    }

    public function rules(): array
    {
        return [
            'file' => ['required', 'file', 'mimes:pdf,doc,docx,zip,rar,png,jpg,jpeg', 'max:51200'],
            'komentar' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
