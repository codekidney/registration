<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider {

    /**
     * Register services.
     *
     * @return void
     */
    public function register() {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        Validator::extend('languages', function ($attribute, $value, $parameters, $validator) {
            $languages = explode(',', $value);

            foreach ($languages as $language) {
                if (strlen($language) < 2) {
                    return false;
                }
            }

            return true;
        });
    }

}
