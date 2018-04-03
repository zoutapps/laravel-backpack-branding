<?php

namespace Zoutapps\Laravel\Backpack\Branding\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Zoutapps\Laravel\Backpack\Branding\Services\BackpackBaseConfigService;
use Zoutapps\Laravel\Backpack\Branding\Services\CopyService;
use Zoutapps\Laravel\Backpack\Branding\Services\EnvService;
use Zoutapps\Laravel\Backpack\Branding\Services\BrandingService;

class BrandingCommand extends Command
{
    use ConfirmableTrait;

    protected $signature = 'za:brand
                    {path? : the path where your branding defaults are}
                    {--no-env : Skip setting .env values}
                    {--no-config : Skip setting config values}
                    {--no-copy : Skip copying the specified files}
                    {--no-helper : Skip setting up the Branding Facade}
                    {--force : Force the operation to run when in production}';

    protected $description = 'Brand your fresh Laravel-Backpack installation';

    public $defaultsPath;

    private $defaults;

    public function handle()
    {
        if (!$this->confirmToProceed()) {
            return false;
        }

        if ($path = $this->argument('path')) {

            if (!$fullPath = realpath($path)) {
                $this->error('Provided defaults path <comment>'.$fullPath.'</comment> does not exist.');
                return false;
            }

            $this->defaultsPath = $fullPath;
        }

        if (!$this->option('no-env')) {
            $envService = new EnvService($this, $this->envPath());
            $envService->perform();
        }

        if (!$this->option('no-config')) {
            $baseConfigService = new BackpackBaseConfigService($this, $this->laravel->basePath('config/backpack/base.php'));
            $baseConfigService->perform();
        }

        if(!$this->option('no-copy')) {
            $copyService = new CopyService($this);
            $copyService->perform();
        }

        if (!$this->option('no-helper')) {
            $helperService = new BrandingService($this);
            $helperService->perform();
        }
    }

    /** @noinspection PhpDocMissingThrowsInspection */
    /**
     * @param string|null $key
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDefaults($key = null)
    {
        if (!$this->defaults && $this->defaultsPath) {
            $content = file_get_contents($this->defaultsPath . '/defaults.json');
            $assoc = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error('Provided defaults.json does not contain valid json.');
            }

            $this->defaults = collect($assoc);
        }

        return $key ? collect($this->defaults[$key] ?? null) : $this->defaults;
    }

    /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }
        return $this->laravel->basePath('.env');
    }
}