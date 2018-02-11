# Dsheiko\Extras

Type manipulation utility-belt bringing JavaScript-like development experience to PHP

## Highlights
- Fixing PHP:
  - Consistent syntax for type extras (first goes manipulation target, then callback or other options)
  - Target always can be as reference as well as type literal
  - Callback can always be any of callable, closure or fully qualified name as a string
- Easy to guess syntax - JavaScript type methods, in addition Underscore.js methods
- Performance: package relies on PHP native methods; no `foreach` where a built-in specific function can be used


## Usage

- [Arrays](./wiki/ARRAYS.md)
- [Strings](./wiki/STRINGS.md)
- [Functions](./wiki/FUNCTIONS.md)
- [Collections](./wiki/COLLECTIONS.md)

## Examples


```php
<?php
use \Dsheiko\Extras\{Arrays, Strings};


$res = Arrays::chain([1, 2, 3])
    ->map(function($num){ return $num + 1; })
    ->filter(function($num){ return $num > 1; })
    ->reduce(function($carry, $num){ return $carry + $num; }, 0)
    ->value();

$res = Strings::from( " 12345 " )
            ->replace("/1/", "5")
            ->replace("/2/", "5")
            ->trim()
            ->substr(1, 3)
            ->get();
echo $res; // "534"

```