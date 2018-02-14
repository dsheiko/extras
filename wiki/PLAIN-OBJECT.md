# Plain Object

Object representing an associative array similar to plain object in JavaScript

## Overview example

```php
<?php
use Dsheiko\Extras\Type\PlainObject;

$po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
// $po = \Dsheiko\Extras\Array::from(["foo" => "FOO", "bar" => "BAR"]);
echo $po->foo; // "FOO"
echo $po->bar; // "BAR"
```

## Methods

- [assign](#assigne)
- [entries](#entries)
- [keys](#keys)
- [toArray](#toArray)
- [values](#values)




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
