<?php

namespace App\Http\Requests\ProgramStudi;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProgramStudiRequest extends FormRequest
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
            'kode' => [
                'required',
                $this->routeName == 'apps.program-studi.store' ? 'unique:program_studis,kode' : Rule::unique('program_studis', 'kode')->ignoreModel($this->programStudi)
            ],
            'nama' => [
                'required',
                $this->routeName == 'apps.program-studi.store' ? 'unique:program_studis,nama' : Rule::unique('program_studis', 'nama')->ignoreModel($this->programStudi)
            ],
            'jurusan_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode program studi harus diisi',
            'kode.unique' => 'Kode program studi sudah ada',
            'nama.required' => 'Nama program studi harus diisi',
            'nama.unique' => 'Nama program studi sudah ada',
            'jurusan_id.required' => 'Pilih jurusan'
        ];
    }
}
