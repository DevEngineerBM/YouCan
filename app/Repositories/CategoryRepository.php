<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryRepository
{


    public function all(): Collection
    {

        return Category::with('parent', 'children')->get();
    }

    public function find(int $id): Category
    {

        return Category::with('parent', 'children')->findOrFail($id);
    }

    public function create(array $data): Category
    {

        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {

        $category->update($data);
        return $category;
    }

    public function delete(Category $category)
    {

        $category->delete();
    }
}
