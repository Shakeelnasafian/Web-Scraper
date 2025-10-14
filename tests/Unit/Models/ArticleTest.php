<?php

namespace Tests\Unit\Models;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function test_article_can_be_created(): void
    {
        $article = Article::create([
            'source' => 'Test Source',
            'title' => 'Test Article',
            'url' => 'https://example.com/test-article',
        ]);

        $this->assertInstanceOf(Article::class, $article);
        $this->assertEquals('Test Source', $article->source);
        $this->assertEquals('Test Article', $article->title);
        $this->assertEquals('https://example.com/test-article', $article->url);
    }

    public function test_article_fillable_attributes(): void
    {
        $article = new Article();
        $fillable = $article->getFillable();

        $expectedFillable = [
            'source',
            'title',
            'url',
            'description',
            'content',
            'url_to_image',
            'published_at',
            'category',
        ];

        foreach ($expectedFillable as $attribute) {
            $this->assertContains($attribute, $fillable, "Expected fillable attribute '{$attribute}' not found in: " . implode(', ', $fillable));
        }
    }

    public function test_article_required_fields(): void
    {
        $this->expectException(\Illuminate\Database\QueryException::class);

        Article::create([
            'description' => 'Test Description',
        ]);
    }

    public function test_article_published_at_is_cast_to_datetime(): void
    {
        $article = Article::create([
            'source' => 'Test Source',
            'title' => 'Test Article',
            'url' => 'https://example.com/test-article',
            'published_at' => '2024-01-01 12:00:00',
        ]);

        $this->assertInstanceOf(\Illuminate\Support\Carbon::class, $article->published_at);
    }

    public function test_article_can_have_category(): void
    {
        $article = Article::create([
            'source' => 'Test Source',
            'title' => 'Test Article',
            'url' => 'https://example.com/test-article',
            'category' => 'Technology',
        ]);

        $this->assertEquals('Technology', $article->category);
    }

    public function test_article_relationships_and_methods(): void
    {
        $article = Article::factory()->create([
            'source' => 'Tech News',
            'category' => 'Technology',
        ]);

        $this->assertNotNull($article->created_at);
        $this->assertNotNull($article->updated_at);
        $this->assertEquals('Tech News', $article->source);
        $this->assertEquals('Technology', $article->category);
    }
}
