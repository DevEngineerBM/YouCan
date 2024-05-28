<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;

class ProductValidator
{
    public static function validateProductData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'image' => 'nullable|file',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id', // Each category_id must exist in categories table
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        return $validator->validated();
    }
}
