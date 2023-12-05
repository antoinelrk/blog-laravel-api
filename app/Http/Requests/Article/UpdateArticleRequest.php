<?php

namespace App\Http\Requests\Article;

use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $data = $this->all();

        if (!isset($this->all()['body']))
        {
            $body = [];
        }
        else {
            $body = (array) json_decode($data['body']);
        }

        unset($data['body']);

        $this->replace([
            ...(array) $body,
            ...(array) ['id' => intval($this->route()->id)],
            ...(array) $data
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => [
                'required',
                Rule::exists('articles', 'id')
            ],
            'title' => [
                'nullable',
                'string',
                'between:8,64',
                Rule::unique('articles')->ignore($this->route()->id)
            ],
            'content_raw' => [
                'nullable'
            ],
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')
            ],
            'image' => [
                'nullable',
                'image'
            ],
            'is_visible' => [
                'nullable',
                'boolean'
            ]
        ];
    }

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
