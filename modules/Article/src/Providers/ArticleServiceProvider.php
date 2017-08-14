<?php

namespace Modules\Article\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

class ArticleServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Modules\Article\Http\Controllers';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerRoutes();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('article.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'article'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/article');

        $sourcePath = __DIR__.'/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/article';
        }, \Config::get('view.paths')), [$sourcePath]), 'article');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/article');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'article');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../resources/lang', 'article');
        }
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerRoutes()
    {
        $routesPath = __DIR__.'/../routes.php';

        Route::middleware('web')
             ->namespace($this->namespace)
             ->prefix('article')
             ->group($routesPath);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
