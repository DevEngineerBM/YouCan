<?php

namespace App\Services;

use App\Models\Category;
use App\Validators\CategoryValidator;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{
    protected $categoryRepository;
    protected $categoryValidator;

    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryValidator $categoryValidator
    ) {

        $this->categoryRepository = $categoryRepository;
        $this->categoryValidator = $categoryValidator;
    }

    public function all(): Collection
    {
        return $this->categoryRepository->all();
    }

    public function find(int $id): Category
    {
        return $this->categoryRepository->find($id);
    }

    public function create(array $data): Category
    {
        $ValidatedData = $this->categoryValidator->validateCategoryData($data);

        return $this->categoryRepository->create($ValidatedData);
    }

    public function update(Category $category, array $data): Category
    {
        $ValidatedData = $this->categoryValidator->validateCategoryData($data);

        return $this->categoryRepository->update($category, $ValidatedData);
    }

    public function delete(Category $category): void
    {
        $this->categoryRepository->delete($category);
    }
}
