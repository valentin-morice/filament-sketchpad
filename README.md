# filament-sketchpad

![Screenshot from 2024-08-24 15-37-49](https://github.com/user-attachments/assets/28b0c2ab-b296-4e60-92d5-45f78c92894c)

A simple package that provides you with a sketchpad field in Filament

## Installation

You can install the package via composer:

```bash
composer require valentin-morice/filament-sketchpad
```

## Usage

The filament-sketchpad plugin works as any other Filament Form Builder class. Make sure the column on which it is called is cast to JSON.

```php
public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Sketchpad::make('example'),
            ]);
    }

// An infolist component is also available.
public static function infolist(Infolist $infolist): Form
    {
        return $form
            ->schema([
                SketchpadInfolist::make('example'),
            ]);
    }
```

### Set the height
```php
FilamentSketchpad::make('example')->height(int 400|Closure); // in px
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
          ];

FilamentSketchpad::make('example')->download(array |Closure $config);
```

### Minimal mode
Display only icons instead of buttons.
```php
FilamentSketchpad::make('example')->minimal(bool|Closure $bool = true);
```
NOTE: All standard injected utilities are available in your closure.

Thanks to [http://yiom.github.io/sketchpad/](http://yiom.github.io/sketchpad/) for the JS.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
