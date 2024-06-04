<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateItineraryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|max:255|unique:itineraries,name',
            'description' => 'sometimes|string',
            /*'user_id' => 'sometimes|exists:users,id',*/
            'length' => 'sometimes|numeric',
            'positive_drop' => 'sometimes|numeric',
            'negative_drop' => 'sometimes|numeric',
            'estimated_time' => 'sometimes|numeric',
            'difficulty' => 'sometimes|string',
            //'source' => 'sometimes|string|in:' . implode(',', SourceEnum::getValues()),
            //'type' => 'sometimes|string|in:' . implode(',', TypeItineraryEnum::getValues()),
            'type' => 'sometimes|string',
            'source' => 'sometimes|string',
            'image' => 'sometimes|image',
            'image_description' => 'sometimes|string',
            'pdf_url' => 'sometimes|url',
            'steps' => 'sometimes|array',
            'steps.*.name' => 'sometimes|string|max:255',
            'steps.*.description' => 'sometimes|string',
            'steps.*.address' => 'sometimes|string',
            'steps.*.latitude' => 'sometimes|numeric',
            'steps.*.longitude' => 'sometimes|numeric',
            'steps.*.order' => 'sometimes|integer',
            'steps.*.stepImage' => 'sometimes|image',
            'steps.*.image_description' => 'sometimes|string',
            'steps.*.external_url' => 'sometimes|url',

        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }
}
