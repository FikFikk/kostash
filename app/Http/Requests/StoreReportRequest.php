<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->role === 'tenants';
    }

    public function rules()
    {
        return [
            'room_id' => 'required|exists:rooms,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:1000',
            'category' => 'required|in:electrical,water,facility,cleaning,security,other',
            'priority' => 'required|in:low,medium,high,urgent',
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'room_id.required' => 'Kamar harus dipilih',
            'room_id.exists' => 'Kamar yang dipilih tidak valid',
            'title.required' => 'Judul laporan harus diisi',
            'title.max' => 'Judul laporan maksimal 255 karakter',
            'description.required' => 'Deskripsi laporan harus diisi',
            'description.min' => 'Deskripsi laporan minimal 10 karakter',
            'description.max' => 'Deskripsi laporan maksimal 1000 karakter',
            'category.required' => 'Kategori harus dipilih',
            'category.in' => 'Kategori yang dipilih tidak valid',
            'priority.required' => 'Prioritas harus dipilih',
            'priority.in' => 'Prioritas yang dipilih tidak valid',
            'images.max' => 'Maksimal 5 gambar yang dapat diunggah',
            'images.*.image' => 'File harus berupa gambar',
            'images.*.mimes' => 'Format gambar yang diizinkan: jpeg, png, jpg, gif',
            'images.*.max' => 'Ukuran gambar maksimal 2MB'
        ];
    }
}
