<?php

namespace Kikechi\Journals;

use Illuminate\Support\ServiceProvider;

class JournalServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerResources();
        $this->defineAssetPublishing();
    }

    /**
     * Register the Invoices routes.
     *
     * @return void
     */
    protected function registerResources(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'journals');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'journals');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    protected function defineAssetPublishing(): void
    {
        $this->publishes([
            JOURNALS_PATH . '/public' => public_path('vendor/journals'),
        ], 'journals.assets');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        if (!defined('JOURNALS_PATH')) {
            define('JOURNALS_PATH', realpath(__DIR__ . '/../'));
        }

        $this->configure();
        $this->offerPublishing();
        $this->registerServices();
        $this->registerCommands();

    }

    /**
     * Set up the configuration for Journal.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/journals.php', 'journals');
    }

    /**
     * Set up the resource publishing groups for Invoices.
     *
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            // Publishing the configuration file.
            $this->publishes([
                __DIR__ . '/../config/journals.php' => config_path(path: 'journals.php'),
            ], 'journals.config');

            // Publishing the views.
            $this->publishes([
                __DIR__ . '/../resources/views' => base_path(path: 'resources/views/vendor/journals'),
            ], 'journals.views');

            // Publishing the translation files.
            $this->publishes([
                __DIR__ . '/../lang' => base_path(path: 'lang/vendor/journals'), //resource_path('lang/vendor/journals'),
            ], 'journals.translations');
        }
    }

    /**
     * Register Invoices' services in the container.
     *
     * @return void
     */
    protected function registerServices(): void
    {
        $this->app->singleton('journal', function ($app) {
            return new Journal;
        });
    }

    /**
     * Register the Invoices Artisan commands.
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallJournalCommand::class,
                Commands\UpdateJournalCommand::class,
            ]);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['journal'];
    }
}