<?php

namespace Zoutapps\Laravel\Backpack\Branding\Services;

use Illuminate\Support\Collection;
use Zoutapps\Laravel\Backpack\Branding\Commands\BrandingCommand;
use Zoutapps\Laravel\Backpack\Branding\Traits\ValueReplacerTrait;

class EnvService
{
    use ValueReplacerTrait;

    private $command;

    private $keys = [
        "APP_NAME",
        "APP_URL",
        "BACKPACK_LICENSE",
        "BACKPACK_REGISTRATION_OPEN",
    ];

    public function __construct(BrandingCommand $command, $env)
    {
        $this->command = $command;
        $this->file = $env;
        $this->appends = true;
        $this->defaults = $this->command->getDefaults('env');
    }

    public function perform()
    {
        if (file_exists($this->file) === false) {
            $this->command->error('You don\'t have a <comment>.env</comment> file.');
            return false;
        }

        $this->command->info('Values for <comment>.env</comment>');
        $this->applyValues();

        return true;
    }

    protected function old($key)
    {
        return $this->escape(env($key));
    }

    protected function escape($value)
    {
        if (str_contains($value, ' ')) {
            return '"' . $value . '"';
        }

        return $value;
    }
}