<?php

namespace App\Http\Requests\PengajuanTA;

use App\Models\JenisDokumen;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();
        $validates = [];
        $messages = [];

        foreach ($docPengajuan as $item) {
            $validates['dokumen_' . $item->id] = $item->tipe_dokumen == 'pdf' ? 'mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
            $messages['dokumen_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
            $messages['dokumen_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
        }
        return [
            'pembimbing_1' => $this->routeName == 'apps.pengajuan-ta.store' ? 'required' : 'nullable',
            'jenis_ta_id' => 'required',
            'topik' => 'required',
            'judul' => 'required',
            'tipe' => 'required',
            // 'dokumen_ringkasan' => $this->routeName == 'apps.pengajuan-ta.store' ? 'required|mimes:docx,pdf|max:5120' : 'nullable|mimes:docx,pdf|max:5120',
            'topik_ta_new' => 'nullable',
            'jenis_ta_new' => 'nullable',
            ...$validates
        ];
    }

    public function messages(): array
    {
        $docPengajuan = JenisDokumen::where('jenis', 'pendaftaran')->get();
            $validates = [];
            $messages = [];

        foreach ($docPengajuan as $item) {
            $validates['dokumen_' . $item->id] = $item->tipe_dokumen == 'pdf' ? 'mimes:pdf|max:' . $item->max_ukuran : 'mimes:png,jpg,jpeg,webp|max:' . $item->max_ukuran;
            $messages['dokumen_' . $item->id . '.mimes'] = 'Dokumen ' . strtolower($item->nama) . ' harus dalam format ' . ($item->tipe_dokumen == 'pdf' ? 'PDF' : 'PNG, JPEG, JPG, WEBP');
            $messages['dokumen_' . $item->id . '.max'] = 'Dokumen ' . strtolower($item->nama) . ' tidak boleh lebih dari ' . $item->max_ukuran . ' KB';
        }
        return [
            'pembimbing_1.required' => 'Dosen pembimbing 1 tidak boleh kosong',
            'jenis_ta_id.required' => 'Jenis TA tidak boleh kosong',
            'topik.required' => 'Topik tidak boleh kosong',
            'judul.required' => 'Judul TA tidak boleh kosong',
            'tipe.required' => 'Tipe tidak boleh kosong',
            // 'dokumen_ringkasan.required' => 'Dokumen ringkasan tidak boleh kosong',
            // 'dokumen_ringkasan.mimes' => 'Dokumen ringkasan harus dalam format PDF atau Docx',
            // 'dokumen_ringkasan.max' => 'Dokumen ringkasan tidak boleh lebih dari 5 MB',
            ...$messages
        ];
    }
}

