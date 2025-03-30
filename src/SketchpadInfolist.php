<?php

namespace ValentinMorice\FilamentSketchpad;

use Closure;
use Filament\Infolists\Components\Entry;

class SketchpadInfolist extends Entry
{
    protected string $view = 'filament-sketchpad::infolist';

    public int | Closure $height = 400;

    public function getHeight(): int
    {
        return $this->evaluate($this->height);
    }

    public function height(int | Closure $height): static
    {
        $this->height = $height;

        return $this;
    }
}
