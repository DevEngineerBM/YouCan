<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CategoryValidator
{
    public static function validateCategoryData(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        if ($validator->fails()) {
            throw new \InvalidArgumentException($validator->errors()->first());
        }

        // If validation passes, return the validated data
        return $validator->validated();
    }
}
