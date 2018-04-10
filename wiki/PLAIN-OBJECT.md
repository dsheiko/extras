# Plain Object

Object representing an associative array similar to plain object in JavaScript

## Overview example

```php
<?php
use Dsheiko\Extras\Type\PlainObject;

$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
// $po = \Dsheiko\Extras\Array::object(["foo" => "FOO", "bar" => "BAR"]);
echo $po->foo; // "FOO"
echo $po->bar; // "BAR"
```

## Methods

- JavaScript-inspired methods
    - [assign](#assigne)
    - [entries](#entries)
    - [keys](#keys)
    - [values](#values)
- Underscore.js-inspired methods
    - [keys](#keys)
    - [values](#values)
    - [mapObject](#mapObject)
    - [pairs](#pairs)
    - [invert](#invert)
    - [findKey](#findKey)
    - [pick](#pick)
    - [omit](#omit)
    - [defaults](#defaults)
    - [has](#has)
    - [isEqual](#isEqual)
    - [isEmpty](#isEmpty)
    - [toArray](#toArray)


## JavaScript-inspired methods

### assign
Copy the values of all properties from one or more source arrays to a target array.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign)

##### Parameters
- `{PlainObject} $target` - target object
- `{array} ...$sources` - variadic list of source plain objects or arrays

###### Syntax
```php
 assign(PlainObject $target, ...$sources): PlainObject
```

###### Example
```php
<?php
$po1 = new PlainObject(["foo" => "FOO"]);
$po2 = new PlainObject(["bar" => "BAR"]);
$res = PlainObject::assign($po1, $po2);
echo $res->foo; // "FOO"
echo $res->bar; // "BAR"
echo $po1->foo; // "FOO"
echo $po1->bar; // "BAR"
```




### entries
Return an array of a given object's own enumerable property [key, value] pairs

###### Syntax
```php
 entries(): array
```

###### Example
```php
<?php
$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
$res = $po->entries();
var_dump($res[0]); // ["foo", "FOO"]
var_dump($res[1]); // ["bar", "BAR"]
```

### keys
Return all the keys or a subset of the keys of a plain object

##### Parameters
- `{string} $searchValue` - [OPTIONAL] substring to look for

###### Syntax
```php
 keys($searchValue = null): array
```

###### Example
```php
<?php
$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
$res = $po->keys(); // ["foo", "bar"]
```


### toArray
Transform back to array


###### Syntax
```php
 toArray(): array
```

###### Example
```php
<?php
$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
$res = $po->toArray();
echo is_array($res); // true
```

### values
Return all the values of a plain object


###### Syntax
```php
 values(): array
```

###### Example
```php
<?php
$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
$res = $po->values(); // ["FOO", "BAR"]
```

## Underscore.js\Objects methods

### mapObject
Like map, but for associative arrays. Transform the value of each property in turn.
- [see also](http://underscorejs.org/#mapObject).

##### Parameters
- `{callable} $iteratee` - iteratee function
- `{object} $context` - (optional) context object to bind to

###### Syntax
```php
 mapObject(callable $iteratee, $context = null): PlainObject
```

###### Example

```php
<?php
$po = new PlainObject([
        "start" => 5,
        "end" => 12,
]);
$res = $po->mapObject(function($val){
    return $val + 5;
}); // PlainObject{ "start": 10, "end": 17 }

```

### pairs
Convert an object into a list of [key, value] pairs. Alias of [entries](#entries)
- [see also](http://underscorejs.org/#pairs).


###### Syntax
```php
 pairs(): array
```

###### Example

```php
<?php
$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
$res = $po->pairs(); // [["foo", "FOO"], ["bar", "BAR"]]
```

### invert
Returns a copy of the object where the keys have become the values and the values the keys. For this to work, all of your object's values should be unique and string serializable.
- [see also](http://underscorejs.org/#invert).


###### Syntax
```php
 invert(): PlainObject
```

###### Example

```php
<?php
$po = new PlainObject([
    "Moe" => "Moses",
    "Larry" => "Louis",
    "Curly" => "Jerome",
]);
$res = $po->invert();
echo $res->Moses; // "Moe"
echo $res->Louis; // "Larry"
echo $res->Jerome; // "Curly"

```

### findKey
Similar to [findIndex](#findIndex), but for keys in objects. Returns the key where the predicate truth test passes or undefined
- [see also](http://underscorejs.org/#findKey).

##### Parameters
- `{callable} $iteratee` - iteratee function
- `{object} $context` - (optional) context object to bind to

###### Syntax
```php
 findKey($iteratee = null, $context = null): string
```

###### Example

```php
<?php
$po = new PlainObject([
    "foo" => [
        'name' => 'Ted',
        'last' => 'White',
    ],
    "bar" => [
        'name' => 'Frank',
        'last' => 'James',
    ],
    "baz" => [
        'name' => 'Ted',
        'last' => 'Jones',
    ],
]);
$res = $po->findKey([ "name" => "Ted" ]); // "foo"

```

### pick
Return a copy of the object, filtered to only have values for the whitelisted keys (or array of valid keys). Alternatively accepts a predicate indicating which keys to pick.
- [see also](http://underscorejs.org/#pick).

##### Parameters
- `{array} ...$keys` - keys or iteratee function

###### Syntax
```php
 pick(...$keys): PlainObject
```

###### Example #1

```php
<?php
$po = new PlainObject([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
]);
$res = $po->pick('name', 'age');
// PlainObject{ 'name': 'moe', 'age': 50 }

```

###### Example #2

```php
<?php
$po = new PlainObject([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
]);

$res = $po->pick(function($value){
    return is_int($value);
});
// PlainObject{ 'age': 50 }

```
### omit
Return a copy of the object, filtered to omit the blacklisted keys (or array of keys). Alternatively accepts a predicate indicating which keys to omit.
- [see also](http://underscorejs.org/#omit).

##### Parameters
- `{array} ...$keys` - keys or iteratee function

###### Syntax
```php
 omit(...$keys): PlainObject
```

###### Example #1

```php
<?php
$po = new PlainObject([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
]);

$res = $po->omit('userid');
// PlainObject{ 'name': 'moe', 'age': 50 }

```

###### Example #2

```php
<?php
$po = new PlainObject([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
]);

$res = $po->omit(function($value){
    return is_int($value);
});
// PlainObject{ 'name': 'moe', 'userid': 'moe1' }

```

### defaults
Fill in undefined properties in object with the first value present in the following list of defaults objects.
- [see also](http://underscorejs.org/#defaults).

##### Parameters
- `{array} $defaults` - key-value array of defaults

###### Syntax
```php
 defaults(array $defaults): PlainObject
```

###### Example

```php
<?php
$po = new PlainObject([
    "flavor" => "chocolate"
]);
$res = $po->defaults([
     "flavor" => "vanilla",
     "sprinkles" => "lots",
]);
// PlainObject{ "flavor": "chocolate", "sprinkles": "lots" }
```

### has
Does the object contain the given key? Identical to object.hasOwnProperty(key), but uses a safe reference to the hasOwnProperty function, in case it's been overridden accidentally.
- [see also](http://underscorejs.org/#has).

##### Parameters
- `{string} $key` - key to look for

###### Syntax
```php
 has(string $key): bool
```

###### Example

```php
<?php
$po = new PlainObject([
     "flavor" => "vanilla",
     "sprinkles" => "lots",
]);
$res = $po->has("flavor"); // true
```

### isEmpty
Returns true if an enumerable object contains no values (no enumerable own-properties).
- [see also](http://underscorejs.org/#isEmpty).

###### Syntax
```php
 isEmpty(): bool
```

###### Example

```php
<?php
$po = new PlainObject([]);

$res = Arrays::isEmpty($po); // true
```