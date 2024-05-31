<?php

namespace App\Http\Requests;

use App\Enums\SourceEnum;
use App\Enums\TypeItineraryEnum; // Add this import statement

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreItineraryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:itineraries,name',
            'description' => 'required|string',
            /*'user_id' => 'required|exists:users,id',*/
            'length' => 'nullable|numeric',
            'positive_drop' => 'nullable|numeric',
            'negative_drop' => 'nullable|numeric',
            'estimated_time' => 'required|numeric',
            'difficulty' => 'required|string',
            //'source' => 'required|string|in:' . implode(',', SourceEnum::getValues()),
            //'type' => 'required|string|in:' . implode(',', TypeItineraryEnum::getValues()),
            'type' => 'required|string',
            'source' => 'required|string',
            'image' => 'required|image',
            'image_description' => 'required|string',
            'pdf_url' => 'nullable|url',
            'steps' => 'required|array',
            'steps.*.name' => 'required|string|max:255',
            'steps.*.description' => 'required|string',
            'steps.*.address' => 'required|string',
            'steps.*.latitude' => 'required|numeric',
            'steps.*.longitude' => 'required|numeric',
            'steps.*.order' => 'required|integer',
            'steps.*.image_step' => 'required|image',
            'steps.*.image_description' => 'required|string',
            'steps.*.external_url' => 'nullable|url',

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
