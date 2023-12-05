<?php

namespace App\Http\Requests\Article;

use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

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
     * On setup les données pour la validation
     */
    protected function prepareForValidation(): void
    {
        $data = $this->all();
        $body = (array) json_decode($data['body']);
        unset($data['body']);
        $this->replace([...(array) $body, ...(array) $data]);
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
                'between:8,64'
            ],
            'content_raw' => [
                'required'
            ],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'image' => [
                'required',
                'image'
            ],
            'is_visible' => [
                'nullable',
                'boolean'
            ]
        ];
    }

    /**
     * @return Exception
     */
    protected function failedValidation(Validator $validator): Exception
    {
        $response = response()->json([
            'success' => false,
            'message' => "Validation errors",
            'errors' => $validator->errors()
        ], Response::HTTP_UNPROCESSABLE_ENTITY);

        throw new HttpResponseException($response);
    }
}
