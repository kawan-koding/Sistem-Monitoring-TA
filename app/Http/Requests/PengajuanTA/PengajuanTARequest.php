<?php

namespace App\Http\Requests\PengajuanTA;

use Illuminate\Foundation\Http\FormRequest;

class PengajuanTARequest extends FormRequest
{
    private $routeName;

    public function __construct()
    {
        $this->routeName = request()->route()->getName();
    }
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
            'pemb_1' => 'required',
            'jenis_ta_id' => 'required',
            'topik' => 'required',
            'judul' => 'required',
            'tipe' => 'required',
            'dokumen_pemb_1' => 'required|mimes:docx,pdf',
            'dokumen_ringkasan' => 'required|mimes:docx,pdf',
        ];
    }

    public function messages(): array
    {
        return [
            'pemb_1.required' => 'Dosen pembimbing 1 tidak boleh kosong',
            'jenis_ta_id.required' => 'Jenis TA tidak boleh kosong',
            'topik.required' => 'Topik tidak boleh kosong',
            'judul.required' => 'Judul TA tidak boleh kosong',
            'tipe.required' => 'Tipe tidak boleh kosong',
            'dokumen_pemb_1.required' => 'Dokumen pembimbing 1 tidak boleh kosong',
            'dokumen_pemb_1.mimes' => 'Dokumen pembimbing 1 harus dalam format PDF atau Docx',
            'dokumen_ringkasan.required' => 'Dokumen ringkasan tidak boleh kosong',
            'dokumen_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau Docx'
        ];
    }
}

