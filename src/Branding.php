<?php

namespace Zoutapps\Laravel\Backpack\Branding;

use Illuminate\Support\Facades\Config;

class Branding
{
    public function asset($key)
    {
        return asset($this->get($key));
    }

    public function link($content = null, $class = null, $target = '_blank')
    {
        return '<a href="'.$this->url().'" '. ($class ? 'class="'.$class.'" ' : '') .'target="'.$target.'">'.($content ? $content : $this->url()).'</a>';
    }

    public function developer()
    {
        return $this->get('developer');
    }

    public function url()
    {
        return $this->get('url');
    }


    private function get($key)
    {
        $configKey = 'zoutapps.branding.' . $key;

        if (!Config::has($configKey)) {
            throw new \InvalidArgumentException('Your branding value '. $key . ' is not specified. Please add the desired value to <comment>config/zoutapps/branding.php</comment> in order to use it.');
        }

        return config($configKey);
    }
}