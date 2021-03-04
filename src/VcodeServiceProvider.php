<?php
namespace Ycpfzf\Vcode;

use Illuminate\Support\ServiceProvider;

class VcodeServiceProvider extends ServiceProvider
{

    public function register()
    {
       //
    }

    public function boot()
    {
         
        $this->publishes([
            __DIR__.'/../config/vcode.php' => config_path('vcode.php'),
            __DIR__.'/../views/default.blade.php' => resource_path('views/emails/default.blade.php'),
        ]);
    }


}
