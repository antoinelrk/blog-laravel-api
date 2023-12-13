<?php

namespace App\Http\Requests\Article;

use App\Traits\SlugTrait;
use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class DeleteArticleRequest extends FormRequest
{
    use SlugTrait;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $id = intval($this->getId($this->route()->slug));
        $this->merge(['id' => $id]);
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
                'numeric',
                Rule::exists('articles', 'id'),
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
