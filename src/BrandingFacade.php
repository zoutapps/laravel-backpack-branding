<?php

namespace Zoutapps\Laravel\Backpack\Branding;

use Illuminate\Support\Facades\Facade;

/**
 * @method static string asset($key)
 * @method static string link($content, $class = null, $target = '_blank')
 * @method static string developer()
 * @method static string url()
 */
class BrandingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'branding';
    }
}