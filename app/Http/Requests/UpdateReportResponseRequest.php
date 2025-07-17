<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReportResponseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Ambil model 'response' dari route.
        $response = $this->route('response');

        // Otorisasi gagal jika tidak ada respons atau pengguna bukan admin.
        if (!$response || Auth::user()->role !== 'admin') {
            return false;
        }

        // Izinkan request hanya jika ID admin pada respons sama dengan ID pengguna yang login.
        return $response->admin_id === Auth::id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Teks respons wajib diisi.
            'response_text' => 'required|string|max:5000',
            
            // Tindakan yang diambil bersifat opsional.
            'action_taken' => 'nullable|string|max:255',
        ];
    }
}
