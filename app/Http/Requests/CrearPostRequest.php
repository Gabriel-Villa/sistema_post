<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CrearPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido.',
            'nombre.max' => 'El nombre no puede tener 255 caracteres como maximo.',
            'nombre.unique' => 'Ya existe un post con este nombre.',
            'post_file.required' => 'Sube una imagen.',
            'post_file.min' => 'Minimo 1 imagen permitida.',
            'post_file.max' => 'Maximo 10 imagenes como permitido.',
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombre' => 'required|unique:posts|max:200',
            'post_file' => 'required|array|min:1|max:10'
        ];
    }
}
