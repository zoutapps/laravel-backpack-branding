<?php

namespace Zoutapps\Laravel\Backpack\Branding\Services;

use Illuminate\Filesystem\Filesystem;
use Zoutapps\Laravel\Backpack\Branding\Commands\BrandingCommand;

class CopyService
{
    private $command;
    private $filesystem;
    private $defaults;

    public function __construct(BrandingCommand $command)
    {
        $this->command = $command;
        $this->filesystem = new Filesystem();
    }

    public function perform()
    {
        $copyDefinitions = collect($this->command->getDefaults('copy'));

        $this->command->info('Found <comment>' . $copyDefinitions->count() . '</comment> paths to copy');

        $copyDefinitions->each(function ($definition) {
            $this->copyFiles($definition['src'], $definition['dest']);
        });
    }

    private function copyFiles($src, $dest)
    {
        $source = realpath($this->command->defaultsPath.'/'.$src);
        $dest = base_path($dest);

        $shouldCopy = $this->command->confirm("Do you want to copy files from <comment>{$source}</comment> to <comment>{$dest}</comment>");

        if ($shouldCopy) {
            $this->filesystem->copyDirectory($source, $dest);
            $this->command->info('COPIED');
        } else {
            $this->command->info('NOT COPIED');
        }
    }
}