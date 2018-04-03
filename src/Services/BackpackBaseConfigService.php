<?php

namespace Zoutapps\Laravel\Backpack\Branding\Services;

use Zoutapps\Laravel\Backpack\Branding\Commands\BrandingCommand;
use Zoutapps\Laravel\Backpack\Branding\Traits\ValueReplacerTrait;

class BackpackBaseConfigService
{
    use ValueReplacerTrait;

    private $command;

    private $keys = [
        "project_name",
        "logo_lg",
        "logo_mini",
        "developer_name",
        "developer_link",
        "show_powered_by",
        "skin",
        "default_date_format",
        "default_datetime_format",
        "route_prefix",
    ];

    public function __construct(BrandingCommand $command, $file)
    {
        $this->command = $command;
        $this->file = $file;
        $this->appends = false;
        $this->defaults = $this->command->getDefaults('config.backpack_base');
    }

    public function perform()
    {
        if (file_exists($this->file) === false) {
            $this->command->error('You don\'t have a the backpack base config file.');
            return false;
        }

        $this->command->info('Please provide your base config values:');

        $this->applyValues();

        //$user_model_fqn
        return true;
    }

    protected function escape($value)
    {
        return "'".$value."'";
    }

    protected function old($key)
    {
        return $this->escape(config('backpack.base:'.$key));
    }

    protected function search($key, $old)
    {
        return '/^[ ]*'.preg_quote("'{$key}'").'[ ]*'.preg_quote("=>").'.*$/m';
    }

    protected function replace($key, $value) {
        return "    '".$key."' => ". $value . ",";
    }
}