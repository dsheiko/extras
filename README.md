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

#### None-reference target, callback as a string
```php
<?php
use \Dsheiko\Extras\Arrays;

function numToArray($num)
{
  return [$num];
}
$res = Arrays::map(range(1,3), "numToArray");
```

#### Chaining
```php
<?php
use \Dsheiko\Extras\Collections;

$res = Collections::chain(new \ArrayObject([1,2,3]))
    ->toArray() // value is [1,2,3]
    ->map(function($num){ return [ "num" => $num ]; })
    // value is [[ "num" => 1, ..]]
    ->reduce(function($carry, $arr){
        $carry .= $arr["num"];
        return $carry;

    }, "") // value is "123"
    ->replace("/2/", "") // value is "13"
    ->value();
echo $res; // "13"

```