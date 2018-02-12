# Dsheiko\Extras

[![Latest Stable Version](https://poser.pugx.org/dsheiko/extras/v/stable)](https://packagist.org/packages/dsheiko/extras)
[![Total Downloads](https://poser.pugx.org/dsheiko/extras/downloads)](https://packagist.org/packages/dsheiko/extras)
[![License](https://poser.pugx.org/dsheiko/extras/license)](https://packagist.org/packages/dsheiko/extras)
[![Build Status](https://travis-ci.org/dsheiko/extras.png)](https://travis-ci.org/dsheiko/extras)

Collection of chainable high-order functions to abstract and manipulate PHP types

> The packages takes its name from `Array Extras` referring to the array methods added in ES5 (JavaScript) to abstract generic array manipulation logic

## Highlights
- Type transformation chains
- Fixing PHP:
  - Consistent syntax for type extras (first always goes manipulation target, then callback or other options)
  - Manipulation target (value) can always be as reference as well as type literal
  - Callback can always be  `callable` or closure or fully qualified name as a string
- Familiar syntax: JavaScript Array/Object/String methods, in addition extra methods in [Underscore.js](http://underscorejs.org/)/[Lodash](https://lodash.com/) syntax
- Performance: package relies on PHP native methods; no `foreach` where a built-in specific function can be used

## Sets

- [Arrays](./wiki/ARRAYS.md)
- [Strings](./wiki/STRINGS.md)
- [Functions](./wiki/FUNCTIONS.md)
- [Collections](./wiki/COLLECTIONS.md)

## Examples

#### None-reference target, callback as a string
```php
<?php
use \Dsheiko\Extras\Arrays;

function numToArray(int $num): array
{
  return [$num];
}
$res = Arrays::map(range(1,3), "numToArray"); // [[1],[2],[3]]
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