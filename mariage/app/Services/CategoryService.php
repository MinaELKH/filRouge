<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CategoryService
{
    protected $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAll()
    {
        return $this->categoryRepository->all();
    }

    public function store($request)
    {
        return $this->categoryRepository->create([
            'name' => $request->name,
            'description' => $request->description
        ]);
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function update($request, Category $category)
    {
        return $this->categoryRepository->update($category, [
            'name' => $request->name,
            'description' => $request->description
        ]);
    }

    public function destroy(Category $category)
    {
        return $this->categoryRepository->delete($category);
    }
}
