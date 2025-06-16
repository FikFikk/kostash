<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportResponseRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'response_text' => 'required|string|min:10|max:1000',
            'action_taken' => 'nullable|string|max:500',
            'estimated_completion' => 'nullable|date|after:now',
            'notes' => 'nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'response_text.required' => 'Respons harus diisi',
            'response_text.min' => 'Respons minimal 10 karakter',
            'response_text.max' => 'Respons maksimal 1000 karakter',
            'action_taken.max' => 'Tindakan yang diambil maksimal 500 karakter',
            'estimated_completion.date' => 'Format tanggal estimasi tidak valid',
            'estimated_completion.after' => 'Tanggal estimasi harus setelah hari ini',
            'notes.max' => 'Catatan maksimal 500 karakter'
        ];
    }
}
