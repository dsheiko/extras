# Dsheiko\Extras

Type manipulation utility-belt bringing JavaScript/Underscore-lie development experience to PHP


## Highlights
- Package relies on PHP native methods; no PHP type juggling, no `foreach` where a built-in specific function can be used
- Package implements methods in JavaScript style and extension methods of Underscore


## Usage

- [Arrays](./wiki/ARRAYS.md)
- [Strings](./wiki/STRINGS.md)
- [Functions](./wiki/FUNCTIONS.md)

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