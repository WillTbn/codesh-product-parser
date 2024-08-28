<?php

namespace App\Http\Requests;

use App\Enums\ProductStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
            // 'code' => 'required|exists:products,code',
            'status' => ['required', Rule::enum(ProductStatus::class)] ,
            'imported_t'=> 'required',
            'last_modified_t'=> 'required',
            'product_name' => 'required',
            'created_t' => 'required',
            'url'=>"",
            'quantity'=>"",
            'brands'=>"",
            'categories'=>"",
            'labels'=>"",
            'cities'=>"",
            'purchase_places'=>"",
            'stores'=>"",
            'ingredients_text'=>"",
            'traces'=>"",
            'serving_size'=>"",
            'serving_quantity'=>"",
            'nutriscore_score'=>"",
            'nutriscore_grade'=>"",
            'main_category'=>"",
            'image_url'=>"",
            'imported_t'=>"",
            'status'=>"",


        ];
    }
}
