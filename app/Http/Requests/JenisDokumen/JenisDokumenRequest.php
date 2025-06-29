<?php

namespace App\Http\Requests\JenisDokumen;

use Illuminate\Foundation\Http\FormRequest;

class JenisDokumenRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => 'required',
            'jenis' => 'required',
            'tipe_dokumen' => 'required',
            'max_ukuran' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama harus diisi',
            'jenis.required' => 'Jenis harus diisi',
            'tipe_dokumen.required' => 'Tipe dokumen harus diisi',
            'max_ukuran.required' => 'Maks. ukuran harus diisi',
        ];
    }
}
