<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReportStatusRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'status' => 'required|in:pending,in_progress,completed,rejected',
            'reason' => 'nullable|string|max:500'
        ];
    }

    public function messages()
    {
        return [
            'status.required' => 'Status harus dipilih',
            'status.in' => 'Status yang dipilih tidak valid',
            'reason.max' => 'Alasan maksimal 500 karakter'
        ];
    }
}
