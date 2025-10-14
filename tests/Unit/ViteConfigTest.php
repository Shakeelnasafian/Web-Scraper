<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class ViteConfigTest extends TestCase
{
    public function test_vite_config_file_exists(): void
    {
        $configPath = base_path('vite.config.js');
        $this->assertFileExists($configPath);
    }

    public function test_vite_config_contains_laravel_plugin(): void
    {
        $configContent = file_get_contents(base_path('vite.config.js'));
        $this->assertStringContainsString('laravel-vite-plugin', $configContent);
        $this->assertStringContainsString('resources/css/app.css', $configContent);
        $this->assertStringContainsString('resources/js/app.js', $configContent);
    }
}
