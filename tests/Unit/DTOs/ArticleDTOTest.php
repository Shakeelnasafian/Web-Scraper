<?php

namespace Tests\Unit\DTOs;

use App\DTOs\ArticleDTO;
use Illuminate\Support\Carbon;
use PHPUnit\Framework\TestCase;

class ArticleDTOTest extends TestCase
{
    public function test_article_dto_can_be_created(): void
    {
        $publishedAt = Carbon::parse('2024-01-01 12:00:00');
        
        $dto = new ArticleDTO(
            source: 'Test Source',
            author: 'Test Author',
            title: 'Test Title',
            description: 'Test Description',
            content: 'Test Content',
            url: 'https://example.com/test',
            urlToImage: 'https://example.com/image.jpg',
            publishedAt: $publishedAt,
            category: 'Technology'
        );

        $this->assertEquals('Test Source', $dto->source);
        $this->assertEquals('Test Author', $dto->author);
        $this->assertEquals('Test Title', $dto->title);
        $this->assertEquals('Test Description', $dto->description);
        $this->assertEquals('Test Content', $dto->content);
        $this->assertEquals('https://example.com/test', $dto->url);
        $this->assertEquals('https://example.com/image.jpg', $dto->urlToImage);
        $this->assertEquals($publishedAt, $dto->publishedAt);
        $this->assertEquals('Technology', $dto->category);
    }

    public function test_article_dto_to_array(): void
    {
        $publishedAt = Carbon::parse('2024-01-01 12:00:00');
        
        $dto = new ArticleDTO(
            source: 'Test Source',
            author: 'Test Author',
            title: 'Test Title',
            description: 'Test Description',
            content: 'Test Content',
            url: 'https://example.com/test',
            urlToImage: 'https://example.com/image.jpg',
            publishedAt: $publishedAt,
            category: 'Technology'
        );

        $array = $dto->toArray();

        $expectedArray = [
            'source' => 'Test Source',
            'author' => 'Test Author',
            'title' => 'Test Title',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'url' => 'https://example.com/test',
            'url_to_image' => 'https://example.com/image.jpg',
            'published_at' => '2024-01-01 12:00:00',
            'category' => 'Technology',
        ];

        $this->assertEquals($expectedArray, $array);
    }

    public function test_article_dto_with_null_values(): void
    {
        $dto = new ArticleDTO(
            source: 'Test Source',
            author: null,
            title: 'Test Title',
            description: null,
            content: null,
            url: 'https://example.com/test',
            urlToImage: null,
            publishedAt: null,
            category: null
        );

        $array = $dto->toArray();

        $this->assertNull($array['author']);
        $this->assertNull($array['description']);
        $this->assertNull($array['content']);
        $this->assertNull($array['url_to_image']);
        $this->assertNull($array['published_at']);
        $this->assertNull($array['category']);
    }
}
