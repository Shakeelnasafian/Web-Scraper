<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create authenticated user for testing.
     */
    protected function createAuthenticatedUser(): \App\Models\User
    {
        $user = \App\Models\User::factory()->create();
        $this->actingAs($user);
        return $user;
    }

    /**
     * Create article for testing.
     */
    protected function createTestArticle(array $attributes = []): \App\Models\Article
    {
        return \App\Models\Article::factory()->create($attributes);
    }

    /**
     * Assert that a response contains specific meta tags.
     */
    protected function assertResponseHasMetaTag(string $name, string $content): void
    {
        $this->assertStringContainsString(
            sprintf('<meta name="%s" content="%s"', $name, $content),
            $this->response->getContent()
        );
    }
}
