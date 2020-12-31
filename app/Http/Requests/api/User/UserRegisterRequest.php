<?php

namespace App\Http\Requests\api\User;

use Illuminate\Foundation\Http\FormRequest;

///**
// * Class UserRegisterRequest
// * @package App\Http\Requests\api\User
// * @property string $name
// * @property  string $username
// * @property  string $email
// * @property  string $password
// */
class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd('ok');
        return[
                'name' => 'alpha|required|min:3|max:15',
                'username' => 'required|min:4|max:15|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|max:16',
            ];
    }

}
