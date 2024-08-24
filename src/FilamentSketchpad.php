<?php

namespace ValentinMorice\FilamentSketchpad;

use Closure;
use Filament\Forms\Components\Field;

class FilamentSketchpad extends Field
{
    protected string $view = 'filament-sketchpad::index';

    public int | Closure $height = 400;

    public function getHeight(): int
    {
        return $this->evaluate($this->height);
    }

    public function height(int | Closure $height): static {
        $this->height = $height;

        return $this;
    }
}
