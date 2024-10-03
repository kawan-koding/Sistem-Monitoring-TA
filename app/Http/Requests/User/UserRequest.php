<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'username' => [
                'required',
                $this->routeName == 'apps.users.store' ? 'unique:users,username' : Rule::unique('users', 'username')->ignoreModel($this->user)
            ],
            'email' => [
                'required',
                $this->routeName == 'apps.users.store' ? 'unique:users,email' : Rule::unique('users', 'email')->ignoreModel($this->user)
            ],
            'password' => $this->routeName == 'apps.users.store' ? 'required' : 'nullable',
            'confirm_password' => $this->routeName == 'apps.users.store' ? 'required|same:password' : 'nullable',
            'picture' => 'nullable|image|mimes:png,jpg,jpeg',
            'roles' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama harus diisi',
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah ada',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',
            'email.unique' => 'Email sudah ada',
            'password.required' => 'Password harus diisi',
            'confirm_password' => 'Konfirmasi password harus diisi',
            'confirm_password.same' => 'Konfirmasi password tidak sama',
            'picture.image' => 'File harus berupa gambar',
            'picture.mimes' => 'File harus png,jpg,jpeg',
            'roles.required' => 'Role harus diisi',
        ];
    }
}
