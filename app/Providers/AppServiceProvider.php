<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Faker\Generator;
use Faker\Provider\pt_BR\Person;
use Faker\Provider\pt_BR\Internet;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Generator::class, function ($app) {
                $faker = new Generator;
                $faker->addProvider(new Person($faker));
                $faker->addProvider(new Internet($faker));
                return $faker;
            }
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
