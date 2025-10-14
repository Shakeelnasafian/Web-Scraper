<?php

namespace Tests\Unit\Models;

use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_category_can_be_created(): void
    {
        $category = Category::create([
            'name' => 'Technology',
        ]);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals('Technology', $category->name);
    }

    public function test_category_name_is_required(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Category::create([]);
    }

    public function test_category_fillable_attributes(): void
    {
        $category = new Category();
        $fillable = $category->getFillable();

        $this->assertContains('name', $fillable);
    }

    public function test_category_timestamps(): void
    {
        $category = Category::create([
            'name' => 'Technology',
        ]);

        $this->assertNotNull($category->created_at);
        $this->assertNotNull($category->updated_at);
    }
}
