<?php

namespace Zoutapps\Laravel\Backpack\Branding\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string asset($key)
 * @method static string link($content, $class = null, $target = '_blank')
 * @method static string developer()
 * @method static string url()
 */
class Branding extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Zoutapps\Laravel\Backpack\Branding\Branding::class;
    }
}