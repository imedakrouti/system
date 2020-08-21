<?php
namespace Student\Providers;
use Illuminate\Support\ServiceProvider;
use File;
class StudentServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $moduleName = basename(dirname(__DIR__));

        // Load my files configuration
        /*
            studentsRoute => key in array config
        */
        config([ $moduleName."Route"=>File::getRequire(loadFileConfiguration('routeConfig',$moduleName))]);
        // Load route files
        $this->loadRoutesFrom(loadRoute('web',$moduleName));
        // Load view
        $this->loadViewsFrom(loadViews($moduleName),$moduleName);
        // load director migrations
        $this->loadMigrationsFrom(loadMigrations($moduleName));
        // load translations [languages]
        $this->loadTranslationsFrom(loadTranslation($moduleName),$moduleName);

    }
}
