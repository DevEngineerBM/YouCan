<?php

namespace App\Services;



use App\Models\Category;
use App\Validators\CategoryValidator;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\Collection;

class CategoryService

{
    protected $CategoryRepository;
    protected $CategoryValidator;

    public function __construct(CategoryRepository $categoryRepository, CategoryValidator $CategoryValidator)
    {

        $this->CategoryRepository = $categoryRepository;
        $this->CategoryValidator = $CategoryValidator;
    }

    public function all(): Collection
    {

        return $this->CategoryRepository->all();
    }

    public function find(int $id): Category
    {

        return $this->CategoryRepository->find($id);
    }

    public function create(array $data): Category
    {
        $ValidatedData = $this->CategoryValidator->validateCategoryData($data);


        return $this->CategoryRepository->create($ValidatedData);
    }

    public function update(Category $category, array $data): Category
    {
        $ValidatedData = $this->CategoryValidator->validateCategoryData($data);

        return $this->CategoryRepository->update($category, $ValidatedData);
    }

    public function delete(Category $category): void
    {

        $this->CategoryRepository->delete($category);
    }
}
