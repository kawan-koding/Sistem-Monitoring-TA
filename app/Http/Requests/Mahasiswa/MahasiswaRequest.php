<?php

namespace App\Http\Requests\Mahasiswa;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
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
            'kelas' => 'required',
            'nim' => [ 
                'required',
                $this->routeName == 'admin.mahasiswa.store' ? 'unique:mahasiswas,nim' : Rule::unique('mahasiswas', 'nim')->ignoreModel($this->mahasiswa)
            ],
            'nama_mhs' => 'required',
            'email' => [
                'required',
                $this->routeName == 'admin.mahasiswa.store' ? 'unique:mahasiswas,email' : Rule::unique('mahasiswas', 'email')->ignoreModel($this->mahasiswa)
            ],
            'jenis_kelamin' => 'nullable',
            'telp' => 'nullable',
            'program_studi_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'kelas.required' => 'Kelas harus diisi',
            'nama_mhs.required' => 'Nama harus diisi',
            'nim.required' => 'NIM harus diisi',
            'nim.unique' => 'NIM sudah ada',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah ada',
            'program_studi_id.required' => 'Program studi harus diisi',
        ];
    }
}
