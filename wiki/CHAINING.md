# Chaining

## Methods

- [chain](#chain)
- [middleware](#middleware)
- [value](#value)


### chain

Iterate over a list of elements, yielding each in turn to an $callable function
- [see also](http://underscorejs.org/#each).

###### Parameters
- `{mixed} $value` - manipulation target

###### Syntax
```php
{Set}::chain($target): Chain
```

###### Example
```php
<?php
// Chain of calls
$res = Chain::from([1, 2, 3]) // same as Arrays::chain([1, 2, 3])
    ->map(function($num){ return $num + 1; })
    ->filter(function($num){ return $num > 1; })
    ->reduce(function($carry, $num){ return $carry + $num; }, 0)
    ->value();
```

### middleware

Binds a middleware (transformer) function to the chain

###### Parameters
- `{callable|string|Closure} $callable` - middleware function

###### Syntax
```php
{Set}::middleware($function): Chain
```

###### Example
```php
<?php
 $res = Chain::from(new \ArrayObject([1,2,3))
        // same as Collections::chain(new \ArrayObject([1,2,3])
        ->toArray()
        ->middleware("json_encode")
        ->value(); // "[1,2,3]"
```

### value

Extracts the value of a wrapped object.

#
###### Syntax
```php
$chain::value()
```
