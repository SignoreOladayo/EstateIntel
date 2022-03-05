<?php

namespace App\Http\Requests\Book;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'string',
            'isbn' => 'string',
            'authors' => 'array',
            'country' => 'string',
            'number_of_pages' => 'integer',
            'publisher' => 'string',
            'released_date' => 'date_format:Y-m-d'
        ];
    }
}
