<?php

namespace App\Http\Requests\PeriodeTA;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PeriodeTARequest extends FormRequest
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
            'nama' => [
                'required',
                $this->routeName == 'apps.periode.store' ? 'unique:periode_tas,nama' : Rule::unique('periode_tas', 'nama')->ignoreModel($this->periode)
            ],
            'mulai_daftar' => 'nullable',
            'akhir_daftar' => 'nullable',
            'mulai_seminar' => 'nullable',
            'akhir_seminar' => 'nullable',
            'mulai_sidang' => 'nullable',
            'akhir_sidang' => 'nullable',    
            'akhir_pemberkasan' => 'nullable',    
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Periode tugas akhir harus diisi',
            'nama.unique' => 'Periode tugas akhir sudah ada',
        ];
    }
}
