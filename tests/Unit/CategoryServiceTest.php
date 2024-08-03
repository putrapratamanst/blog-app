<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Mockery;
use Pest\Laravel\mock;

it('can retrieve category by id', function () {
    // Arrange
    $categoryId = 1;
    $category = Mockery::mock(Category::class);
    $categoryService = new CategoryService($category);
    
    // Expect the `findOrFail` method to be called with $categoryId and return a fake category
    $category->shouldReceive('findOrFail')
             ->with($categoryId)
             ->andReturn((object) ['id' => $categoryId, 'name' => 'Test Category']);

    // Act
    $result = $categoryService->getCategoryById($categoryId);

    // Assert
    expect($result->id)->toBe($categoryId);
    expect($result->name)->toBe('Test Category');
});

it('throws an exception if category not found', function () {
    // Arrange
    $categoryId = 999;
    $category = Mockery::mock(Category::class);
    $categoryService = new CategoryService($category);
    
    // Expect the `findOrFail` method to throw a ModelNotFoundException
    $category->shouldReceive('findOrFail')
             ->with($categoryId)
             ->andThrow(new ModelNotFoundException());

    // Act & Assert
    expect(fn () => $categoryService->getCategoryById($categoryId))
        ->toThrow(ModelNotFoundException::class);
});
