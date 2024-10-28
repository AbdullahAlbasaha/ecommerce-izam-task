<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\HelperTrait;
use Illuminate\Contracts\Validation\Validator;
class UpdateProductRequest extends FormRequest
{
    use HelperTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($this->expectsJson()) {
            $this->response_has_errors($validator->errors(),'Update Product Failed',422);
        }
        parent::failedValidation($validator);
    }
    public function rules(): array
    {
        $product_id = $this->route()->parameter('product')->id;
        return [
             'sku' => 'sometimes|string|max:50|unique:products,sku,'.$product_id.',id',
            'name' => 'sometimes|string|max:191',
            'price' => ['sometimes','numeric',function($attribute,$value,$fail){
                if ($value < 1 || $value > 99999999) {
                    $fail("price should be greater than 1 and less than 99999999");
                }
            }],
            'stock' => 'sometimes|integer|gt:0',
        ];
    }
}
