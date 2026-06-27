# filament-sketchpad

![Screenshot from 2024-08-24 15-37-49](https://github.com/user-attachments/assets/28b0c2ab-b296-4e60-92d5-45f78c92894c)

A simple package that provides you with a sketchpad field in Filament.

## Compatibility

| Filament | filament-sketchpad |
|----------|--------------------|
| 5.x      | 2.x (this version) |
| 3.x      | 1.x                |

## Installation

You can install the package via composer:

```bash
composer require valentin-morice/filament-sketchpad
```

## Usage

The filament-sketchpad plugin works as any other Filament schema component. Make sure the column on which it is called is cast to `array` (or `json`).

```php
use ValentinMorice\FilamentSketchpad\Sketchpad;
use Filament\Schemas\Schema;

public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Sketchpad::make('example'),
            ]);
    }

// An infolist component is also available.
use ValentinMorice\FilamentSketchpad\SketchpadInfolist;

public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                SketchpadInfolist::make('example'),
            ]);
    }
```

### Set history configuration
```php
// Provide full or partial configuration.
// Keys 'undo' and 'redo' are mandatory.

$config = [
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

FilamentSketchpad::make('example')->history(array |Closure $config);
```

### Set controls configuration
```php
// Provide full or partial configuration.
// Keys 'clear' and 'reset' are mandatory.

$config = [
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

FilamentSketchpad::make('example')->controls(array |Closure $config);
```

### Set download configuration
```php
// Provide full or partial configuration.
$config = [
            'label' => 'Download',
            'icon' => 'heroicon-m-arrow-down-tray',
            'color' => 'gray',
            'filename' => 'my-sketch', // saved as my-sketch.png
          ];

FilamentSketchpad::make('example')->download(array |Closure $config);
```

### Minimal mode
Display only icons instead of buttons.
```php
FilamentSketchpad::make('example')->minimal(bool|Closure $bool = true);
```

### Set the height
```php
FilamentSketchpad::make('example')->height(int 400|Closure); // in px
```
NOTE: All standard injected utilities are available in your closures.

## Translations

All button labels and the read-only empty state respect Laravel's active locale.
English (`en`) and French (`fr`) ship with the package. To customise or add a
locale, publish the translations and edit the file:

```bash
php artisan vendor:publish --tag=filament-sketchpad-translations
```

This creates `lang/vendor/filament-sketchpad/{locale}/sketchpad.php`, exposing the
`undo`, `redo`, `clear`, `reset`, `download` and `empty` keys.

Thanks to [http://yiom.github.io/sketchpad/](http://yiom.github.io/sketchpad/) for the JS.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
