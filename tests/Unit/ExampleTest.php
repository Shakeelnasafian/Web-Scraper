<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_that_true_is_true(): void
    {
        $this->assertTrue(true);
    }

    /**
     * Test basic PHP functionality.
     */
    public function test_array_operations(): void
    {
        $array = ['a', 'b', 'c'];
        $this->assertCount(3, $array);
        $this->assertContains('b', $array);
    }

    /**
     * Test string operations.
     */
    public function test_string_operations(): void
    {
        $string = 'Web Scraper Application';
        $this->assertStringContainsString('Scraper', $string);
        $this->assertEquals(23, strlen($string));
    }
}
