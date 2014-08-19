<?php namespace Tobz\Autoform\Facade;

use Illuminate\Support\Facades\Facade;

class Autoform extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'autoform';
    }
}
