<?php

namespace ValentinMorice\FilamentSketchpad;

use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentSketchpadServiceProvider extends PackageServiceProvider
{
    public static string $name = 'filament-sketchpad';

    public static string $viewNamespace = 'filament-sketchpad';

    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name(static::$name)
            ->hasViews()
            ->hasTranslations();
    }

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make('filament-sketchpad-js', __DIR__ . '/../resources/js/filament-sketchpad.js'),
            Css::make('filament-sketchpad', __DIR__ . '/../resources/css/filament-sketchpad.css'),
        ], 'filament-sketchpad');
    }
}
