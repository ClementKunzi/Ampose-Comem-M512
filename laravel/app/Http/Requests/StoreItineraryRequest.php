<?php

namespace App\Http\Requests;

use App\Enums\SourceEnum;
use App\Enums\TypeItineraryEnum; // Add this import statement

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'user_id' => 'required|exists:users,id',
            'length' => 'required|numeric',
            'positive_drop' => 'required|numeric',
            'negative_drop' => 'required|numeric',
            'estimated_time' => 'required|numeric',
            'difficulty' => 'required|numeric',
            'source' => 'required|string|in:' . implode(',', SourceEnum::getValues()),
            'type' => 'required|string|in:' . implode(',', TypeItineraryEnum::getValues()),
            'image' => 'required|image',
            'pdf_url' => 'nullable|url',
        ];
    }
}
