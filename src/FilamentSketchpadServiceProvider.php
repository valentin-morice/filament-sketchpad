<?php

namespace ValentinMorice\FilamentSketchpad;

use Filament\Support\Assets\AlpineComponent;
use Filament\Support\Assets\Asset;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Filesystem\Filesystem;
use Livewire\Features\SupportTesting\Testable;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use ValentinMorice\FilamentSketchpad\Commands\FilamentSketchpadCommand;
use ValentinMorice\FilamentSketchpad\Testing\TestsFilamentSketchpad;

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
            ->hasViews();

        $configFileName = $package->shortName();
    }

    public function packageRegistered(): void {}

    public function packageBooted(): void
    {
        FilamentAsset::register([
            Js::make('sketchpad', __DIR__ . '/../resources/js/sketchpad.js'),
        ]);
    }
}
