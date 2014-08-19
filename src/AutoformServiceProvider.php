<?php namespace Tobz\Autoform;

use Tobz\Autoform\Autoform;
use Illuminate\Support\ServiceProvider;
use App;

class AutoformServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        App::bind('autoform', function () {
            return new Autoform;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
