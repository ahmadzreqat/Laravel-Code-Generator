<?php


namespace generator;

use generator\Console\GeneratorCommands;
use Illuminate\Support\ServiceProvider;

class GenServiceProvider extends ServiceProvider
{


    public function register()
    {

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/./../resources/views', 'gen');

    }


    public function boot()
    {
        $this->commands([GeneratorCommands::class]);
        $this->registerPublishable();
    }


    private function registerPublishable()
    {
        $basePath = dirname(__DIR__);

        $PublishAble = [
            'config.generator' => [
                "$basePath/publish/config/generator.php" => config_path('generator.php')
            ]
        ];

        foreach ($PublishAble as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

}
