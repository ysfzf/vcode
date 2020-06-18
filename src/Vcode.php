<?php
namespace Ycpfzf\Vcode;

use Illuminate\Support\Facades\Facade;

class Vcode extends Facade
{

    static function getFacadeAccessor()
    {
        return ValidCode::class;

    }
}
