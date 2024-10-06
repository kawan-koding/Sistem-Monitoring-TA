<?php

namespace App\Http\Requests\Dosen;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DosenRequest extends FormRequest
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
            'nip' => [
                'required',
                $this->routeName == 'apps.dosen.store' ? 'unique:dosens,nip' : Rule::unique('dosens', 'nip')->ignoreModel($this->dosen)
            ],
            'nidn' => [
                'required',
                $this->routeName == 'apps.dosen.store' ? 'unique:dosens,nidn' : Rule::unique('dosens', 'nidn')->ignoreModel($this->dosen)
            ],
            'name' => [
                'required',
                $this->routeName == 'apps.dosen.store' ? 'unique:dosens,name' : Rule::unique('dosens', 'name')->ignoreModel($this->dosen)
            ],
            'email' => [
                'required',
                $this->routeName == 'apps.dosen.store' ? 'unique:dosens,email' : Rule::unique('dosens', 'email')->ignoreModel($this->dosen)
            ],
            'jenis_kelamin' => 'required',
            'telp' => 'nullable',
            'program_studi_id' => 'nullable',
            'file' => 'nullable|image|mimes:png,jpg,jpeg',
        ];
    }

    public function messages()
    {
        return [
            'nip.required' => 'NIP harus diisi',
            'nip.unique' => 'NIP sudah ada',
            'nidn.required' => 'NIDN harus diisi',
            'nidn.unique' => 'NIDN sudah ada',
            'name.required' => 'Nama harus diisi',
            'name.unique' => 'Nama sudah ada',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah ada',
            'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
            'file.image' => 'File harus berupa gambar',
            'file.mimes' => 'File harus png,jpg,jpeg',
        ];
    }
}
