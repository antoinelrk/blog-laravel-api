<?php

namespace App\Http\Requests\Article;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CreateArticleRequest extends FormRequest
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
            'title' => [
                'required',
                'string',
                'between:8,64',
            ],
            'content_raw' => [
                'required',
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id'),
            ],
            'image' => [
                'required',
                'image',
            ],
            'is_visible' => [
                'nullable',
                'boolean',
            ],
        ];
    }

    protected function failedValidation(Validator $validator): Exception
    {
        $response = response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'errors' => $validator->errors(),
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
