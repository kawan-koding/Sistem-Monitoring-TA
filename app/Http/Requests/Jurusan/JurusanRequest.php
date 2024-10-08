<?php

namespace App\Http\Requests\Jurusan;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class JurusanRequest extends FormRequest
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
                $this->routeName == 'apps.jurusan.store' ? 'unique:jurusans,kode' : Rule::unique('jurusans', 'kode')->ignoreModel($this->jurusan)
            ],
            'nama' => [
                'required',
                $this->routeName == 'apps.jurusan.store' ? 'unique:jurusans,nama' : Rule::unique('jurusans', 'nama')->ignoreModel($this->jurusan)
            ],
        ];
    }


    public function messages(): array
    {
        return [
            'kode.required' => 'Kode jurusan harus diisi',
            'kode.unique' => 'Kode jurusan sudah ada',
            'nama.required' => 'Nama jurusan harus diisi',
            'nama.unique' => 'Nama jurusan sudah ada',
        ];
    }
}
