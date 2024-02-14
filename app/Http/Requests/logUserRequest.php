<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class logUserRequest extends FormRequest
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
            "email"=>'required|email|exists:users,email',
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
        "emai.required"=>"Une adresse mail est obligatoire",
        "email.email"=>"Adresse email non valide",
        "email.exists"=>"Un compte avec cette address email n'existe pas",
        "password.required"=>"Un mot de passe est obligatoire"
       ];
    }
}
