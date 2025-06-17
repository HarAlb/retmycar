<?php

namespace App\Http\Requests;

use App\Http\Enums\StorageFileEnum;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'model_id' => 'required|exists:car_models,id',
            'city_id' => 'required|exists:cities,id',
            'seats' => 'required|string|max:255',
            'price' => 'required',
            'transmission' => 'required',
            'fuel' => 'required',
            'images' => 'nullable|array',
            'images.*' => [
                'nullable',
                'file',
                'min:1',
                'max:' . StorageFileENUM::UPLOAD_MAX_FILE_SIZE * 1024 * 1024
            ],
            'save_image_ids' => 'nullable|array',
            'save_image_ids.*' => 'nullable|integer'
        ];
    }
}
