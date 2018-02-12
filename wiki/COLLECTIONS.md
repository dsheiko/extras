# Collection extras

Following types `iterable`, `ArrayObject`, `Iterator` belong to collections.
Array extras like `::map`, `::reduce` do not make sense on a live collection,
one can rather convert the collection to an array (`::toArray`) and then apply array extras.

## Methods

- [each](#each)
- [toArray](#toArray)
- [chain](#chain)


### each

Iterate over a list of elements, yielding each in turn to an $callable function
[see also](http://underscorejs.org/#each).

###### Parameters
- `{iterable|ArrayObject|Iterator} $collection` - source collection
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
each($collection, $callable)
```

###### Example
```php
<?php
$sum = 0;
$obj = new \ArrayObject([1,2,3]);
Collections::each($obj->getIterator(), function ($i) use (&$sum){
    $sum += $i;
});
```


### toArray

Convert collectionb to an array

###### Parameters
- `{iterable|ArrayObject|Iterator} $collection` - source collection

###### Syntax
```php
toArray($collection)
```

###### Example
```php
<?php
$sum = 0;
$obj = new \ArrayObject([1,2,3]);
$res = Collections::toArray();
```


### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{iterable|ArrayObject|Iterator} $collection` - source collection

###### Syntax
```php
 chain({iterable|ArrayObject|Iterator} $collection)
```

###### Example
```php
<?php
$res = $res = Collections::chain(new \ArrayObject([1,2,3]))
            ->toArray()
            ->value();
echo $res; // "534"
```