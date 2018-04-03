<?php

namespace Zoutapps\Laravel\Backpack\Branding\Traits;

use Illuminate\Support\Str;

trait ValueReplacerTrait
{
    protected $file;

    protected $appends = false;
    protected $defaults;

    protected function escape($value)
    {
        return $value;
    }

    protected function old($key)
    {
        return null;
    }

    protected function replace($key, $value)
    {
        return $key . '=' . $value;
    }

    protected function search($key, $old)
    {
        return '/^' . $key . preg_quote('=' . $old, '/') . '.*$/m';
    }

    protected function applyValues()
    {
        collect($this->keys)->each(function ($key) {
            if ($this->defaults->has($key)) {
                $this->setValueForKey($this->defaults[$key], $key);
                $this->defaults->forget($key);
            } else {
                $value = $this->command->ask($key);
                $this->setValueForKey($value, $key);
            }
        });

        $this->defaults->each(function ($value, $key) {
           $this->setValueForKey($value, $key);
        });
    }

    protected function setValueForKey($value, $key)
    {
        if (is_bool($value)) {
            $value = $value ? 'true': 'false';
        }

        $value = $this->escape($value);
        $replace = $this->replace($key, $value);

        if (Str::contains(file_get_contents($this->file), $key) === false) {
            if (!$this->appends) {
                return;
            }
            file_put_contents($this->file, PHP_EOL . $replace, FILE_APPEND);
        } else {
            $old = $this->old($key);
            $search = $this->search($key, $old);

            $currentContent = file_get_contents($this->file);
            $replacedContent = preg_replace($search, $replace, $currentContent);
            file_put_contents($this->file, $replacedContent);
        }
        if (isset($this->command)) {
            $this->command->line("Setting <comment>{$replace}</comment>");
        }

    }
}