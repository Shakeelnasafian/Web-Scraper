<?php

namespace Tests\Unit\Contracts;

use App\Contracts\ContentFetcherInterface;
use PHPUnit\Framework\TestCase;

class ContentFetcherInterfaceTest extends TestCase
{
    public function test_content_fetcher_interface_exists(): void
    {
        $this->assertTrue(interface_exists(ContentFetcherInterface::class));
    }

    public function test_content_fetcher_interface_has_fetch_content_method(): void
    {
        $reflection = new \ReflectionClass(ContentFetcherInterface::class);
        $this->assertTrue($reflection->hasMethod('fetchContent'));
    }

    public function test_fetch_content_method_signature(): void
    {
        $reflection = new \ReflectionClass(ContentFetcherInterface::class);
        $method = $reflection->getMethod('fetchContent');
        
        $this->assertEquals('fetchContent', $method->getName());
        $this->assertEquals(1, $method->getNumberOfParameters());
        
        $parameters = $method->getParameters();
        $this->assertEquals('url', $parameters[0]->getName());
        $this->assertEquals('string', $parameters[0]->getType()->getName());
    }
}
