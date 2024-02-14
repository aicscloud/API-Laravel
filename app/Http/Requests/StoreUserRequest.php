<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreUserRequest extends FormRequest
{
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
            "name" =>'required',
            "email"=>'required | unique:users,email',
            "password"=>'required'
        ];
    }

    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
            "success"=>false,
            "error"=>true,
            "message"=>"Problème de validation des champs",
            "ErrorList"=>$validator->errors()
        ]));
    }

    public function message(){
       return  [
        "name.required"=>"Le nom est obligatoire",
        "emai.required"=>"Une adresse mail estobligatoire",
        "email.unique"=>"Cette addresse mail est déjà utilisé",
        "password.required"=>"Un mot de passe est obligatoire"
       ];
    }
}
