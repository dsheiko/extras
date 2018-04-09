# Any extras

## Overview example

```php
<?php
use \Dsheiko\Extras\Any;

$res = Any::chain(new \ArrayObject([1,2,3]))
    ->toArray() // value is [1,2,3]
    ->map(function($num){ return [ "num" => $num ]; })
    // value is [[ "num" => 1, ..]]
    ->reduce(function($carry, $arr){
        $carry .= $arr["num"];
        return $carry;

    }, "") // value is "123"
    ->replace("/2/", "") // value is "13"
    ->then(function($value){
      if (empty($value)) {
        throw new \Exception("Empty value");
      }
      return $value;
    })
    ->value();
echo $res; // "13"

```

## Methods

- [isDate](#isDate)
- [isError](#isError)
- [isException](#isException)
- [isNull](#isNull)
- [chain](#chain)


### isDate
Returns true if source is an instance of DateTime.

##### Parameters
- `{mixed} $source` - value to check

###### Syntax
```php
 isDate($source): bool
```

###### Example
```php
<?php
$res = Any::isDate(new DateTime('2011-01-01T15:03:01.012345Z')); // true
```

### isError
Returns true if source is an Error

##### Parameters
- `{mixed} $source` - value to check

###### Syntax
```php
 isError($source): bool
```

###### Example
```php
<?php
try {
    throw new Error("message");
} catch (\Error $ex) {
    $res = Any::isError($ex); // true
}
```

### isException
Returns true if source is an Exception

##### Parameters
- `{mixed} $source` - value to check

###### Syntax
```php
 isException($source): bool
```

###### Example
```php
<?php
try {
    throw new Error("message");
} catch (\Exception $ex) {
    $res = Any::isException($ex); // true
}
```


### isNull
Returns true if source is NULL

##### Parameters
- `{mixed} $source` - value to check

###### Syntax
```php
 isNull($source): bool
```

###### Example
```php
<?php
Any::isNull(null); // true
```

### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{string} $value` - source

###### Syntax
```php
 chain(string $value)
```
