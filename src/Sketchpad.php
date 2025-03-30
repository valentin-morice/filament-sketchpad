<?php

namespace ValentinMorice\FilamentSketchpad;

use Closure;
use Filament\Forms\Components\Field;
use InvalidArgumentException;

class Sketchpad extends Field
{
    protected string $view = 'filament-sketchpad::index';

    public int | Closure $height = 400;

    public bool $minimal = false;

    public array | Closure $history = [
        'undo' => [
            'label' => 'Undo',
            'icon' => 'heroicon-o-arrow-left',
            'color' => 'gray',
        ],
        'redo' => [
            'label' => 'Redo',
            'icon' => 'heroicon-o-arrow-right',
            'color' => 'gray',
        ],
    ];

    public array | Closure $controls = [
        'clear' => [
            'label' => 'Clear',
            'icon' => 'heroicon-o-document',
            'color' => 'gray',
        ],
        'reset' => [
            'label' => 'Reset',
            'icon' => 'heroicon-o-trash',
            'color' => 'gray',
        ],
    ];

    public array | Closure $download = [
        'label' => 'Download',
        'icon' => 'heroicon-m-arrow-down-tray',
        'color' => 'primary',
    ];

    public function getHeight(): int
    {
        return $this->evaluate($this->height);
    }

    public function getMinimal(): bool
    {
        return $this->evaluate($this->minimal);
    }

    public function getHistory(): array
    {
        return $this->evaluate($this->history);
    }

    public function getControls(): array
    {
        return $this->evaluate($this->controls);
    }

    public function getDownload(): array
    {
        return $this->evaluate($this->download);
    }

    public function height(int | Closure $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function minimal(bool $minimal = true): static
    {
        $this->minimal = $minimal;

        return $this;
    }

    /**
     * Configure the history (undo/redo) buttons.
     *
     * Allows partial overrides of the default configuration. Only 'undo' and 'redo'
     * keys are permitted at the top level.
     *
     * Example:
     * ->history([
     *     'undo' => ['label' => 'Go Back', 'icon' => 'fas-undo'],
     *     'redo' => ['color' => 'info']
     * ])
     *
     * @param array{
     *     undo?: array{label?: string, icon?: string, color?: string},
     *     redo?: array{label?: string, icon?: string, color?: string}
     * }|Closure $config An associative array with 'undo' and/or 'redo' keys,
     *                      or a Closure that returns such an array. Values are
     *                      arrays potentially containing 'label', 'icon', and 'color'.
     *
     * @throws InvalidArgumentException If the configuration is invalid.
     */
    public function history(array | Closure $config): static
    {
        $evaluated = $this->evaluate($config);

        if (! is_array($evaluated)) {
            throw new InvalidArgumentException('Parameter must resolve to an array.');
        }

        $allowedKeys = ['undo', 'redo'];
        $providedKeys = array_keys($evaluated);
        $invalidKeys = array_diff($providedKeys, $allowedKeys);

        if (! empty($invalidKeys)) {
            throw new InvalidArgumentException(
                'Invalid key(s) provided for history configuration: ' . implode(', ', $invalidKeys) .
                '. Only "undo" and "redo" are allowed.'
            );
        }

        $this->history = array_replace_recursive($this->history, $evaluated);

        return $this;
    }

    /**
     * Configure the controls (clear/reset) buttons.
     *
     * Allows partial overrides of the default configuration. Only 'clear' and 'reset'
     * keys are permitted at the top level.
     *
     * Example:
     * ->controls([
     *     'clear' => ['label' => 'Go Back', 'icon' => 'fas-undo'],
     *     'reset' => ['color' => 'info']
     * ])
     *
     * @param array{
     *     clear?: array{label?: string, icon?: string, color?: string},
     *     reset?: array{label?: string, icon?: string, color?: string}
     * }|Closure $config An associative array with 'clear' and/or 'reset' keys,
     *                      or a Closure that returns such an array. Values are
     *                      arrays potentially containing 'label', 'icon', and 'color'.
     *
     * @throws InvalidArgumentException If the configuration is invalid.
     */
    public function controls(array | Closure $config): static
    {
        $evaluated = $this->evaluate($config);

        if (! is_array($evaluated)) {
            throw new InvalidArgumentException('Parameter must resolve to an array.');
        }

        $allowedKeys = ['clear', 'reset'];
        $providedKeys = array_keys($evaluated);
        $invalidKeys = array_diff($providedKeys, $allowedKeys);

        if (! empty($invalidKeys)) {
            throw new InvalidArgumentException(
                'Invalid key(s) provided for history configuration: ' . implode(', ', $invalidKeys) .
                '. Only "clear" and "reset" are allowed.'
            );
        }

        $this->history = array_replace_recursive($this->history, $evaluated);

        return $this;
    }

    /**
     * Configure the download button.
     *
     * Allows partial overrides of the default configuration.
     *
     * Example:
     * ->download([
     *     'label' => 'Save Sketch',
     *     'color' => 'success',
     *     'filename' => 'my-sketch.png'
     * ])
     *
     * @param array{
     *     label?: string,
     *     icon?: string,
     *     color?: string,
     * }|Closure $config An associative array potentially containing 'label', 'icon',
     *                      'color', and 'filename' keys, or a Closure that returns
     *                      such an array.
     *
     * @throws InvalidArgumentException If the configuration is invalid.
     */
    public function download(array | Closure $config): static
    {
        $evaluated = $this->evaluate($config);

        if (! is_array($evaluated)) {
            throw new InvalidArgumentException('Parameter must resolve to an array.');
        }

        $this->download = array_replace_recursive($this->download, $evaluated);

        return $this;
    }
}
