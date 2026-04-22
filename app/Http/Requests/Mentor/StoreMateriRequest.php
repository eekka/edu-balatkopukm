<?php

namespace App\Http\Requests\Mentor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMateriRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()?->role === 'mentor';
    }

    public function rules(): array
    {
        return [
            'judul' => ['required', 'string', 'max:255'],
            'isi' => ['nullable', 'string'],
            'pertemuan' => ['required', 'integer', 'min:1'],
            'tipe' => ['required', 'in:pdf,ppt,video,link,artikel'],
            'file' => [
                Rule::requiredIf(fn (): bool => in_array($this->input('tipe'), ['pdf', 'ppt', 'video'], true)),
                'nullable',
                'file',
                'mimes:pdf,ppt,pptx,mp4,mov,avi,wmv,mkv',
                'max:51200',
            ],
            'url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
