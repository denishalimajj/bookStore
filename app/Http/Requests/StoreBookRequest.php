<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\Traits\HandlesValidationErrors;

class StoreBookRequest extends FormRequest
{
    use HandlesValidationErrors;
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255|unique:books,title',
            'author' => 'required|string|max:255',
            'publication_year' => 'required|integer|min:0|max:' . date('Y'),
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'Title must be a string',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'author.required' => 'The author field is required.',
            'author.string' => 'Author must be a string',
            'author.max' => 'The author may not be greater than 255 characters.',
            'publication_year.required' => 'Publication year is required',
            'publication_year.integer' => 'The publication year must be an integer.',
            'publication_year.min' => 'The publication year must be between 0 and the current year.',
            'publication_year.max' => 'The publication year must be between 0 and the current year.',
        ];
    }

}
