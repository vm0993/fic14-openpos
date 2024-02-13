<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SetupUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
          'nama_perusahaan'  => 'required|string|min:1',
          'alamat'           => 'required|string|min:1',
          'code'             => 'required|string|min:1',
          'nama_outlet'      => 'required|string|min:1',
          'email_outlet'     => 'email|unique:outlets,email',
          'email'            => 'email|unique:users,email',
          'password'         => 'required|min:8',
          'password_confirm' => 'required|min:8|same:password',
          'name'             => 'required|min:4',
        ];
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
