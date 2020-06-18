<?php
namespace Ycpfzf\Vcode;

use Illuminate\Support\Facades\Facade;

/**
 * Class Vcode
 * @package Ycpfzf\Vcode
 * @method static  \Ycpfzf\Vcode\ValidCode sms()
 * @method static  \Ycpfzf\Vcode\ValidCode email()
 * @method static  \Ycpfzf\Vcode\ValidCode scene(string $scene)
 * @method static  \Ycpfzf\Vcode\ValidCode name(string $name)
 * @method static  \Ycpfzf\Vcode\ValidCode assign(array $assign)
 * @method static  \Ycpfzf\Vcode\ValidCode subject(string $subject)
 * @method static  \Ycpfzf\Vcode\ValidCode send()
 * @method static  \Ycpfzf\Vcode\ValidCode queue()
 * @method static  \Ycpfzf\Vcode\ValidCode check(string $code)
 *
 * @see \Ycpfzf\Vcode\ValidCode
 *
 */
class Vcode extends Facade
{

    static function getFacadeAccessor()
    {
        return ValidCode::class;

    }
}
