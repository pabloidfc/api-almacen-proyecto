<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
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
        Validator::extend('fecha_mayor_actual', function ($attribute, $value, $parameters, $validator) {
            $fechaActualMontevideo = now('America/Montevideo');
            return strtotime($value) > strtotime($fechaActualMontevideo);
        });

        Validator::extend('fecha_menor_actual_mas_dos_dias', function ($attribute, $value, $parameters, $validator) {
            $fechaActualMontevideo = now('America/Montevideo');
            $fechaActualMasDosDias = $fechaActualMontevideo->addDays(2);
        
            return strtotime($value) <= $fechaActualMasDosDias->timestamp;
        });
    }
}
