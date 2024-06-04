<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use App\Services\BookService;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Http\Requests\Traits\HandlesValidationErrors;
class UpdateBookRequest extends FormRequest
{

    use HandlesValidationErrors;
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        parent::__construct();
        $this->bookService = $bookService;
    }

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|filled|max:255|string',
            'author' => 'sometimes|filled|max:255|string',
            'publication_year' => 'sometimes|filled|integer|min:0|max:' . date('Y'),
        ];
    }
    


    public function messages()
    {
        return [
            'title.filled' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'title.unique' => 'The title has already been taken.',
            'author.filled' => 'The author field is required.',
            'author.string' => 'Author must be a string',
            'author.max' => 'The author may not be greater than 255 characters.',
            'publication_year.filled' => 'Publication year is required',
            'publication_year.integer' => 'The publication year must be an integer.',
            'publication_year.min' => 'The publication year must be between 0 and the current year.',
            'publication_year.max' => 'The publication year must be between 0 and the current year.',
        ];
    }

}


