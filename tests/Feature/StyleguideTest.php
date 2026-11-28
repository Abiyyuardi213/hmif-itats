<?php

namespace Tests\Feature;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class StyleguideTest extends TestCase
{
    public function test_styleguide_returns_404_when_environment_is_production(): void
    {
        $router = new Router($this->app['events'], $this->app);
        $this->app->instance('router', $router);
        Route::swap($router);

        $this->app->detectEnvironment(fn () => 'production');
        Route::middleware('web')->group(base_path('routes/web.php'));
        $router->getRoutes()->refreshNameLookups();
        $router->getRoutes()->refreshActionLookups();

        $this->assertFalse($router->has('styleguide'));
        $this->get('/_styleguide')->assertNotFound();
    }

    public function test_styleguide_renders_successfully_when_environment_is_local(): void
    {
        $router = new Router($this->app['events'], $this->app);
        $this->app->instance('router', $router);
        Route::swap($router);

        $this->app->detectEnvironment(fn () => 'local');
        Route::middleware('web')->group(base_path('routes/web.php'));
        $router->getRoutes()->refreshNameLookups();
        $router->getRoutes()->refreshActionLookups();

        $this->assertTrue($router->has('styleguide'));
        $this->get('/_styleguide')
            ->assertOk()
            ->assertSee('Galeri komponen HMIF ITATS')
            ->assertSee('Mode gelap');
    }
}
