<?php

namespace App\Http\Requests;

use App\Enums\SourceEnum;
use App\Enums\TypeItineraryEnum;
use App\Enums\NameTaxonomyEnum; // Add this import statement

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule; // Add this import statement

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
            'type' => ['required', Rule::in(array_values(TypeItineraryEnum::toArray()))],
            'source' => ['required', Rule::in(array_values(SourceEnum::toArray()))],
            'categories' => ['required', Rule::in(array_values(NameTaxonomyEnum::toArray()))],
            'accessibilities' => ['required', Rule::in(array_values(NameTaxonomyEnum::toArray()))],
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
            'steps.*.stepImage' => 'required|image',
            'steps.*.image_description' => 'required|string',
            'steps.*.external_url' => 'nullable|url',

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
