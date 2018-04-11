# Chaining

## Methods

- [chain](#chain)
- [then](#then)
- [tap](#tap)
- [value](#value)


### chain
- alias: `Any::chain`

Iterate over a list of elements, yielding each in turn to an $callable function
- [see also](http://underscorejs.org/#each).



###### Parameters
- `{mixed} $value` - manipulation target

###### Syntax
```php
{Set}::chain($target): Chain
```

###### Example #1
```php
<?php
use Dsheiko\Extras\Chain;

// Chain of calls
$res = Chain::chain([1, 2, 3]) // same as Arrays::chain([1, 2, 3])
    ->map(function($num){ return $num + 1; })
    ->filter(function($num){ return $num > 1; })
    ->reduce(function($carry, $num){ return $carry + $num; }, 0)
    ->value(); // 9
```

###### Example #2
```php
<?php
use Dsheiko\Extras\Chain;

class MapObject
{
    public $foo = "FOO";
    public $bar = "BAR";
}

$res = Chain::chain(new MapObject)
  ->keys()
  ->value(); // ["foo", "bar"]
```

### then

Binds a then (transformer) function to the chain

###### Parameters
- `{callable} $callable` - then function

###### Syntax
```php
{Set}::then($function): Chain
```

###### Example
```php
<?php
use Dsheiko\Extras\Chain;

$res = Chain::chain(new \ArrayObject([1,2,3))
        // same as Collections::chain(new \ArrayObject([1,2,3])
        ->toArray()
        ->then("json_encode")
        ->value(); // "[1,2,3]"
```

### tap
Underscore syntax for [then](#then)

###### Parameters
- `{callable} $callable` - then function

###### Syntax
```php
{Set}::tap($function): Chain
```

### value

Extracts the value of a wrapped object.

#
###### Syntax
```php
$chain::value()
```
