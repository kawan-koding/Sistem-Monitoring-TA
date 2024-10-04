<?php

namespace App\Http\Requests\RekomendasiTopik;

use Illuminate\Foundation\Http\FormRequest;

class RekomendasiTopikRequest extends FormRequest
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
            'jenis_ta_id' => 'required',
            'judul' => 'required',
            'tipe' => 'required',
            'kuota' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'jenis_ta_id.required' => 'Jenis TA wajib diisi',
            'judul.required' => 'Judul TA wajib diisi',
            'tipe.required' => 'Tipe wajib diisi',
            'kuota.required' => 'Kuota wajib diisi',
        ];
    }
}
