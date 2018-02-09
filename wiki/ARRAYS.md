# Array extras
> Collection of utilities similar to JavaScript array extras

Hereby presented a set of static methods to manipulate arrays. Some are wrappers of PHP respective functions and some extra functions inspired by Underscore library.

## Objectives

- One doesn't need to worry that PHP array function throws "Only variables can be passed by reference" fatal error
- One doesn't need to worry that PHP array function doesn't accept non-closure callable
- Most important, one can chain multiple functions and avoid temporary variables

```php
<?php
// Accept non-reference array
Arrays::each([1, 2, 3], function(){});

// Accept user defined / built-in functions
Arrays::each([1, 2, 3], "\\var_dump");
Arrays::each([1, 2, 3], [$this, "foo"]);

// Chain of calls
$res = Arrays::chain([1, 2, 3])
    ->map(function($num){ return $num + 1; })
    ->filter(function($num){ return $num > 1; })
    ->reduce(function($carry, $num){ return $carry + $num; }, 0)
    ->value();

```

- JavaScript-inspired methods
	- [each](#each)
	- [map](#map)
	- [reduce](#reduce)
	- [reduceRight](#reduceRight)
	- [filter](#filter)
	- [find](#find)
	- [sort](#sort)
	- [values](#values)
	- [keys](#keys)
	- [from](#from)
	- [some](#some)
	- [every](#every)
	- [assign](#assign)
- Underscore.js-inspired methods
	- [first](#first)
	- [last](#last)
	- [pairs](#pairs)
	- [result](#result)
	- [findIndex](#findIndex)
	- [where](#where)
	- [groupBy](#groupBy)
	- [countBy](#countBy)
	- [shuffle](#shuffle)
	- [chain](#chain)
- Other methods
	- [toObject](#toObject)
	- [replace](#replace)
	- [sAssocArray](#sAssocArray)


## JavaScript-inspired methods

### each

Iterate over a list of elements, yielding each in turn to an $callable function
[see also](http://underscorejs.org/#each).

###### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
each(array $array, $callable)
```

###### Example
```php
<?php
$sum = 0;
Arrays::each([1, 2, 3], function ($val) use(&$sum) {
    $sum += $val;
});
```

### map
Produce a new array of values by mapping each value in list through a transformation function
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce).

###### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 map(array $array, $callable): array
```

###### Example
```php
<?php
// Map sequential array
$res = Arrays::map([1, 2, 3], function($num){ return $num + 1; });

// Map associative array
$res = Arrays::chain([
            "foo" => "FOO",
            "bar" => "BAR",
        ])
        ->pairs()
        ->map(function($pair){
          // key + value
          return $pair[0] . $pair[1];
        })
        ->value();
```

### reduce
Boil down a list of values into a single value.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce).

###### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the callable. If no initial value is supplied, the first element in the array will be used.

###### Syntax
```php
 reduce(array $array, $callable, $initial = null): mixed
```

###### Example

```php
<?php
$sum = Arrays::reduce([1, 2, 3], function ($carry, $num) { return $carry + $num; }, 0);
// 6
```

### reduceRight
The right-associative version of reduce.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/ReduceRight).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the callable. If no initial value is supplied, the first element in the array will be used.


###### Syntax
```php
 reduceRight(array $array, $callable, $initial = null): mixed
```

###### Example

```php
<?php
$res = Arrays::reduceRight([1,2,3], function(array $carry, int $num){
  $carry[] = $num;
  return $carry;
}, []);
// [3,2,1]
```

### filter
Look through each value in the list, returning an array of all the values that pass a truth test (predicate).
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 filter(array $array, $callable): array
```

###### Example
```php
<?php
$array = Arrays::filter([1, 2, 3], function($num){ return $num > 1; });
```

### find
Look through each value in the list, returning the first one that passes a truth test (predicate),
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/find).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 find(array $array, $callable): mixed
```

###### Example
```php
<?php
$value = Arrays::find([1, 2, 3], function($num){ return $num > 1; });
```

### sort
Sort an array by values (using a user-defined comparison function when callback provided)
[see also](http://php.net/manual/en/function.usort.php).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 sort(array $array, $callable = null): array
```

###### Example
```php
<?php
$res = Arrays::sort([3,2,1]);  // [1,2,3]

$res = Arrays::sort([3,2,1], function($a, $b){
            return $a <=> $b;
        });  // [1,2,3]
```

### values
Return all the values of an array
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/values).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 values(array $array): array
```

###### Example

```php
<?php
$res = Arrays::values([ 5 => 1, 10 => 2, 100 => 3]); // [1,2,3]
```

### keys
Return all the keys or a subset of the keys of an array
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys).

##### Parameters
- `{array} $array` - source array
- `{mixed} $searchValue` - if specified, then only keys containing these values are returned.

###### Syntax
```php
 keys(array $array, $searchValue = null): array
```

###### Example

```php
<?php
$res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"]); // ["foo", "bar"]
$res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"], "BAR"); // ["bar"]
```

### from
Create a new array from an array-like or iterable object
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/from).

##### Parameters
- `{ArrayObject|\ArrayIterator|Traversable|Object} $collection` - source collection

###### Syntax
```php
 from($collection): array
```

###### Example

```php
<?php
$res = Arrays::from(new \ArrayObject([1,2,3])); // [1,2,3]

$obj = new \ArrayObject([1,2,3]);
$res = Arrays::from($obj->getIterator()); // [1,2,3]
```


### some
Test whether at least one element in the array passes the test implemented by the provided function
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/some).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 some(array $array, $callable): bool
```

###### Example
```php
<?php
$boolean = Arrays::some([1, 2, 3], function($num){ return $num > 1; });
```

### every
Test whether all elements in the array pass the test implemented by the provided function.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/every).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 every(array $array, $callable): bool
```

###### Example
```php
<?php
$boolean = Arrays::every([1, 2, 3], function($num){ return $num > 1; });
```

### assign(array $array, ...$sources)
Copy the values of all properties from one or more source arrays to a target array.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign).
The method works pretty much like `array_merge` except it treats consistently associative arrays with numeric keys

##### Parameters
- `{array} $array` - target array
- `...$sources` - source one or more arrays

###### Syntax
```php
 assign(array $array, ...$sources): array
```

###### Example
```php
<?php
$res = Arrays::assign(["foo" => 1, "bar" => 2], ["bar" => 3], ["foo" => 4], ["baz" => 5]);
// $res === ["foo" => 4, "bar" => 3, "baz" => 5]

$res = Arrays::assign([10 => "foo", 20 => "bar"], [20 => "baz"]);
// $res === [ 10 => "foo", 20 => "baz" ]
```

## Underscore.js-inspired methods

### first
Get the first value from an array regardless index order and without modifying the array
When passed in array has no element, it returns undefined, unless `$defaultValue` is supplied.
Then it returns $defaultValue (when `$defaultValue` is a callable then the result of its execution)
[see also](http://underscorejs.org/#first).

##### Parameters
- `{array} $array` - source array
- `{mixed} $defaultValue` - scalar or callable

###### Syntax
```php
 first(array $array, $defaultValue = null): mixed
```

###### Example
```php
<?php
$element = Arrays::first([1, 2, 3]);
$element = Arrays::first($arr, 1);
$element = Arrays::first($arr, function(){ return 1; });
```

### last
Get the last value from an array regardless index order and without modifying the array
[see also](http://underscorejs.org/#last).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 last(array $array): mixed
```

###### Example
```php
<?php
$element = Arrays::last([1, 2, 3]);
```

### pairs
Convert an object into a list of [key, value] pairs.
[see also](http://underscorejs.org/#pairs).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 pairs(array $array): array
```

###### Example
```php
<?php
$res = Arrays::pairs([
            "foo" => "FOO",
            "bar" => "BAR",
        ]);
// [["foo", "FOO"], ["bar", "BAR"]]
```

### result
If the value of the named property is a function then invoke it; otherwise, return it.
[see also](http://underscorejs.org/#result).

##### Parameters
- `{array} $array` - source array
- `{string} $prop` - property/key name

###### Syntax
```php
 result(array $array, string $prop): mixed
```

###### Example

```php
<?php
 $options = [
      "foo" => "FOO",
      "bar" => function(){ return "BAR"; },
  ];
  $res = Arrays::result($options, "foo"); // FOO
  $res = Arrays::result($options, "bar"); // BAR
```

### findIndex
Find index of the first element matching the condition in `$callable`
[see also](http://underscorejs.org/#findIndex).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 findIndex(array $array, $callable): mixed
```

###### Example
```php
<?php
$inx = Arrays::findIndex([
            ["val" => "FOO"],
            ["val" => "BAR"],
        ], function ($item){
            return $item["val"] === "BAR";
        }); // 1
```

### where
Look through each value in the list, returning an array of all the values that contain all of the key-value pairs listed in $conditions
[see also](http://underscorejs.org/#where).

##### Parameters
- `{array} $array` - source array
- `{array} $conditions` - key-value pairs to match

###### Syntax
```php
 where(array $array, array $conditions): array
```

###### Example

```php
<?php
$arr = ["foo" => "FOO", "bar" => "BAR", "baz" => "BAZ"];
$res = Arrays::where($arr, ["foo" => "FOO", "bar" => "BAR"]); // ["foo", "bar"]
```

### groupBy
Split a collection into sets, grouped by the result of running each value through iterator
[see also](http://underscorejs.org/#groupBy).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 groupBy(array $array, $callable): array
```

###### Example

```php
<?php
$res = Arrays::groupBy([1.3, 2.1, 2.4], function($num) { return floor($num); });
// [1 => [ 1.3 ], 2 => [ 2.1, 2.4 ]]
```

### countBy
Sort a list into groups and return a count for the number of objects in each group.
[see also](http://underscorejs.org/#countBy).

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback

###### Syntax
```php
 countBy(array $array, $callable): array
```

###### Example

```php
<?php
$res = Arrays::countBy([1, 2, 3, 4, 5], function($num) {
    return $num % 2 == 0 ? "even": "odd";
});
// [ "odd => 3, "even" => 2 ]
```

### shuffle
Return a shuffled copy of the list
[see also](http://underscorejs.org/#shuffle).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 shuffle(array $array): array
```

###### Example

```php
<?php
$res = Arrays::shuffle([1, 2, 3]); // [ 2, 1, 3 ]
```

### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 chain($array): Arrays
```

###### Example

```php
<?php
$res = Arrays::chain([1, 2, 3])
    ->map(function($num){ return $num + 1; })
    ->filter(function($num){ return $num > 1; })
    ->reduce(function($carry, $num){ return $carry + $num; }, 0)
    ->value();
```

## Other methods

### toObject
Convert array to a plain object.

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 toObject(array $array): PlainObject
```

###### Example

```php
$obj = Arrays::toObject([ "foo" =>
            [
                "bar" => [
                    "baz" => "BAZ"
                ]
            ]
        ]);
echo $obj->foo->bar->baz; // BAZ
```

### replace
Replace (similar to MYSQL REPLACE statement) an element matching the condition in `$callable` with the value
If no match found, add the value to the end of array

##### Parameters
- `{array} $array` - source array
- `{callable|string|Closure} $callable` - iteratee callback
- `{mixed} $element` - element to replace the match

###### Syntax
```php
 replace(array $array, $callable, $element): array
```

###### Example
```php
<?php
$array = Arrays::replace([
            ["val" => "FOO"],
            ["val" => "BAR"],
        ], function ($item){
            return $item["val"] === "BAR";
        }, ["val" => "BAZ"]);
```

### isAssocArray
Test whether array is not sequential, but associative array

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 isAssocArray(array $array): bool
```

###### Example
```php
<?php
$bool = Arrays::isAssocArray([1, 2, 3]); // false
```