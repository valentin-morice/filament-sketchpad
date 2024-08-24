# filament-sketchpad

A simple package that provides you with a sketchpad field in Filament

## Installation

You can install the package via composer:

```bash
composer require valentin-morice/filament-sketchpad
```

## Usage

The filament-sketchpad plugin works as any other Filament Form Builder class. Make sure the column on which it is called is cast to JSON or array within your Eloquent model.

```php
public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FilamentSketchpad::make('example'),
            ]);
    }
```

### Set the height
```php
FilamentSketchpad::make('example')->height(int 400|Closure); // in px
```
NOTE: All standard injected utilities are available in your closure.

Thanks to [http://yiom.github.io/sketchpad/](http://yiom.github.io/sketchpad/) for the JS.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
