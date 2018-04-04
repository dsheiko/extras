fevery# Array extras

## Overview examples

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
  - [assign](#assign)
  - [concat](#concat)
  - [copyWithin](#copyWithin)
  - [each](#each)
  - [entries](#entries) - alias: `pairs`
  - [every](#every)
  - [fill](#fill)
  - [filter](#filter)
  - [find](#find)
  - [from](#from)
  - [hasOwnProperty](#hasOwnProperty)
  - [includes](#includes)
  - [indexOf](#indexOf)
  - [is](#is)
  - [join](#join)
  - [keys](#keys)
  - [lastIndexOf](#lastIndexOf)
  - [map](#map)
  - [of](#of)
  - [pop](#pop)
  - [push](#push)
  - [reduceRight](#reduceRight)
  - [reduce](#reduce)
  - [reverse](#reverse)
  - [shift](#shift)
  - [slice](#slice)
  - [some](#some)
  - [sort](#sort)
  - [splice](#splice)
  - [unshift](#unshift)
  - [values](#values)
- Underscore.js-inspired methods
  - [every](#every)
  - [chain](#chain)
  - [countBy](#countBy)
  - [difference](#difference)
  - [each](#each)
  - [filter](#filter)
  - [find](#find)
  - [findIndex](#findIndex)
  - [first](#first)
  - [groupBy](#groupBy)
  - [intersection](#intersection)
  - [last](#last)
  - [map](#map)
  - [object](#object)
  - [pairs](#entries) - alias: `entries`
  - [partition](#partition)
  - [pluck](#pluck)
  - [reduceRight](#reduceRight)
  - [reduce](#reduce)
  - [result](#result)
  - [some](#some)
  - [shuffle](#shuffle)
  - [uniq](#uniq)
  - [unzip](#unzip)
  - [where](#where)
  - [zip](#zip)
- Other methods
  - [isAssocArray](#isAssocArray)
  - [replace](#replace)

## JavaScript-inspired methods


### assign(array $array, ...$sources)
Copy the values of all properties from one or more target arrays to a target array.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/assign).
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

### concat
Merge two or more arrays
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/concat).

##### Parameters
- `{array} $array` - source array
- `{array} ...$targets` - arrays to merge

###### Syntax
```php
 concat(array $array, array ...$targets): array
```

###### Example
```php
<?php
$res = Arrays::concat([1, 2], [3, 4], [5, 6]); // [1, 2, 3, 4, 5, 6]
```

### copyWithin
Shallow copy part of an array to another location in the same array and returns it, without modifying its size.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/copyWithin).

##### Parameters
- `{array} $array` - source array
- `{int} $targetIndex` - zero based index at which to copy the sequence to
- `{int} $beginIndex` - (optional) zero based index at which to start copying elements from
- `{int} $endIndex ` - (optional) zero based index at which to end copying elements from

###### Syntax
```php
 copyWithin(
        array $array,
        int $targetIndex,
        int $beginIndex = 0,
        int $endIndex = null
    ): array
```

###### Example
```php
<?php
$res = Arrays::copyWithin([1, 2, 3, 4, 5], 0, 3, 4); // [4, 2, 3, 4, 5]
```

### each

Iterate over a list of elements, yielding each in turn to an iteratee function
- [see also](http://underscorejs.org/#each).

###### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback

###### Syntax
```php
each(array $array, callable $callable)
```

###### Example
```php
<?php
$sum = 0;
Arrays::each([1, 2, 3], function ($val) use(&$sum) {
    $sum += $val;
});
```

### entries / pairs
Convert an object into a list of [key, value] pairs.
- [see also](http://underscorejs.org/#pairs)
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/entries).

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

### every
Test whether all elements in the array pass the test implemented by the provided function.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/every).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback

###### Syntax
```php
 every(array $array, callable $callable): bool
```

###### Example
```php
<?php
$res = Arrays::every([1, 2, 3], function($num){ return $num > 1; }); // false
```

### fill
Fill all the elements of an array from a start index to an end index with a static value.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/fill).

##### Parameters
- `{array} $array` - source array
- `{mixed} $value` - value to fill an array
- `{int} $beginIndex` - (optional) start index, defaults to 0
- `{int} $endIndex` - (optional) end index, defaults to array length

###### Syntax
```php
 fill(array $array, $value, int $beginIndex = 0, int $endIndex = null): array
```

###### Example
```php
<?php
$res = Arrays::fill([1, 2, 3], 4); // [4, 4, 4]
$res = Arrays::fill([1, 2, 3], 4, 1); // [1, 4, 4]
```

### filter
Look through each value in the list, returning an array of all the values that pass a truth test (predicate).
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/filter).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback

###### Syntax
```php
 filter(array $array, callable $callable): array
```

###### Example
```php
<?php
$array = Arrays::filter([1, 2, 3], function($num){ return $num > 1; });
```

### find
Look through each value in the list, returning the first one that passes a truth test (predicate),
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/find).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback

###### Syntax
```php
 find(array $array, callable $callable): mixed
```

###### Example
```php
<?php
$value = Arrays::find([1, 2, 3], function($num){ return $num > 1; });
```

### from
Create a new array from an array-like or iterable object
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/from).

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

### hasOwnProperty
Return a boolean indicating whether the object has the specified property
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/hasOwnProperty).

##### Parameters
- `{array} $array` - source array
- `{string} $key` - the property to test

###### Syntax
```php
 hasOwnProperty(array $array, string $key): bool
```

###### Example
```php
<?php
$res = Arrays::hasOwnProperty(["foo" => "FOO"], "foo");// true
```

### includes
Determine whether an array includes a certain element, returning true or false as appropriate.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/includes).

##### Parameters
- `{array} $array` - source array
- `{mixed} $searchElement` - the element to search for
- `{int} $fromIndex` - (optional) the position in this array at which to begin searching for searchElement.

###### Syntax
```php
 includes(array $array, $searchElement, int $fromIndex = null): bool
```

###### Example
```php
<?php
$res = Arrays::includes([1, 2, 3], 2); // true
$res = Arrays::includes([1, 2, 3, 5, 6, 7], 2, 3); // false
```

### indexOf
Return the first index at which a given element can be found in the array, or -1 if it is not present
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/indexOf).

##### Parameters
- `{array} $array` - source array
- `{mixed} $searchElement` - the element to search for
- `{int} $fromIndex` - (optional) the index to start the search at. If the index is greater than or equal to the array's length.

###### Syntax
```php
 indexOf(array $array, $searchElement, int $fromIndex = 0): int
```

###### Example
```php
<?php
$src = ["ant", "bison", "camel", "duck", "bison"];
$res = Arrays::indexOf($src, "bison"); // 1
$res = Arrays::indexOf($src, "bison", 2); // 4
```

### is
Determine whether two values are the same value.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/is).

##### Parameters
- `{array} $array` - source array
- `{array} $arrayToCompare` - source array

###### Syntax
```php
 is(array $array, array $arrayToCompare): bool
```

###### Example
```php
<?php
$a = [1,2,3];
$b = [1,2,3];
$res = Arrays::is($a, $b); // true


$a = [[["foo" => "FOO", "bar" => "BAR"]]];
$b = [[["foo" => "FOO", "bar" => "BAR"]]];
$res = Arrays::is($a, $b); // true
```

### join
Join all elements of an array into a string and returns this string.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/join).

##### Parameters
- `{array} $array` - source array
- `{string} $separator` - (optional) Specifies a string to separate each pair of adjacent elements of the array. The separator is converted to a string if necessary. If omitted, the array elements are separated with a comma (",").

###### Syntax
```php
 join(array $array, string $separator = ","): string
```

###### Example
```php
<?php
$res = Arrays::join([1,2,3], ":"); // "1:2:3"
```

### keys
Return all the keys or a subset of the keys of an array
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys).

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

### lastIndexOf
Return the last index at which a given element can be found in the array, or -1 if it is not present.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/lastIndexOf).

##### Parameters
- `{array} $array` - source array
- `{mixed} $searchValue` - element to locate in the array.
- `{int} $fromIndex` - (optional) the index at which to start searching backwards. Defaults to the array's length minus one

###### Syntax
```php
 lastIndexOf(array $array, $searchElement, int $fromIndex = null): int
```

###### Example

```php
<?php
$src = [2, 5, 9, 2];
$res = Arrays::lastIndexOf($src, 2); // 3
$res = Arrays::lastIndexOf($src, 2, 2); // 0
```

### map
Produce a new array of values by mapping each value in list through a transformation function
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce).

###### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback

###### Syntax
```php
 map(array $array, callable $callable): array
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

### of
Create a new array with a variable number of arguments, regardless of number or type of the arguments.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/of).

###### Parameters
- `{array} ...$args` - elements of which to create the array

###### Syntax
```php
 function of(...$args): array
```

###### Example
```php
<?php
 $res = Arrays::of(1, 2, 3); // [1, 2, 3]
```

### pop
Remove the last element from an array and returns that element. This method changes the length of the array.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/pop).

###### Parameters
- `{array} $array` - source array

###### Syntax
```php
 pop(array &$array)
```

###### Example
```php
<?php
 $src = [1, 2, 3];
 $res = Arrays::pop($src); // 3
```

### push
Add one or more elements to the end of an array and returns the new length of the array.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/push).

###### Parameters
- `{array} $array` - source array
- `{mixed} $value` - the elements to add to the end of the array

###### Syntax
```php
 push(array $array, $value): array
```

###### Example
```php
<?php
 $src = [1,2,3];
 $res = Arrays::push($src, 4); // [1, 2, 3, 4]
```

### reduceRight
The right-associative version of reduce.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/ReduceRight).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the callable. If no initial value is supplied, the first element in the array will be used.


###### Syntax
```php
 reduceRight(array $array, callable $callable, $initial = null): mixed
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

### reduce
Boil down a list of values into a single value.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reduce).

###### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the callable. If no initial value is supplied, the first element in the array will be used.

###### Syntax
```php
 reduce(array $array, callable $callable, $initial = null): mixed
```

###### Example

```php
<?php
$sum = Arrays::reduce([1, 2, 3], function ($carry, $num) { return $carry + $num; }, 0);
// 6
```

### reverse
Reverse an array in place. The first array element becomes the last, and the last array element becomes the first.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/reverse).

###### Parameters
- `{array} $array` - source array

###### Syntax
```php
 reverse(array $array): array
```

###### Example

```php
<?php
$res = Arrays::reverse([1,2,3]); // [3, 2, 1]
```

### shift
Remove the first element from an array and returns that removed element. This method changes the length of the array.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/shift).

###### Parameters
- `{array} $array` - source array

###### Syntax
```php
 shift(array &$array)
```

###### Example

```php
<?php
$src = [1, 2, 3];
$res = Arrays::shift($src); // 1
```

### slice
Return a shallow copy of a portion of an array into a new array object selected
from begin to end (end not included). The original array will not be modified.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/slice).

##### Parameters
- `{array} $array` - source array
- `{int} $beginIndex` - zero-based index at which to begin extraction.
- `{int} $endIndex` - (optional) zero-based index before which to end extraction.

###### Syntax
```php
 slice(array $array, int $beginIndex, int $endIndex = null): array
```

###### Example
```php
<?php
$src = ["Banana", "Orange", "Lemon", "Apple", "Mango"];
$res = Arrays::slice($src, 1, 3); // ["Orange","Lemon"]
```


### some
Test whether at least one element in the array passes the test implemented by the provided function
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/some).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback

###### Syntax
```php
 some(array $array, callable $callable): bool
```

###### Example
```php
<?php
$res = Arrays::some([1, 2, 3], function($num){ return $num > 1; }); // true
```



### sort
Sort an array by values (using a user-defined comparison function when callback provided)
- [see also](http://php.net/manual/en/function.usort.php).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback

###### Syntax
```php
 sort(array $array, callable $callable = null): array
```

###### Example
```php
<?php
$res = Arrays::sort([3,2,1]);  // [1,2,3]

$res = Arrays::sort([3,2,1], function($a, $b){
            return $a <=> $b;
        });  // [1,2,3]
```

### splice
Change the contents of an array by removing existing elements and/or adding new elements.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/splice).

##### Parameters
- `{array} $array` - source array
- `{int} $beginIndex` - index at which to start changing the array (with origin 0)
- `{int} $deleteCount` - (optional) an integer indicating the number of old array elements to remove.
- `{array} ...$items` - (optional) the elements to add to the array, beginning at the start index.

###### Syntax
```php
 splice(array $array, int $beginIndex, int $deleteCount = null, ...$items): array
```

###### Example
```php
<?php
// remove 1 element from index 2, and insert "trumpet"
$src = ["angel", "clown", "drum", "sturgeon"];
$res = Arrays::splice($src, 2, 1, "trumpet"); // ["angel", "clown", "trumpet", "sturgeon"]
```

### unshift
Add one or more elements to the beginning of an array and returns the new length of the array
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/unshift).

###### Parameters
- `{array} $array` - source array
- `{array} ...$values` - the elements to add to the front of the array

###### Syntax
```php
 unshift(array &$array, ...$values)
```

###### Example

```php
<?php
$src = [1, 2];
$src = Arrays::unshift($src, 0); // [0, 1, 2]
$res = Arrays::unshift($src, -2, -1); // [-2, -1, 0, 1, 2]
```

### values
Return all the values of an array
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/values).

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



## Underscore.js-inspired methods

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

### countBy
Sort a list into groups and return a count for the number of objects in each group.
- [see also](http://underscorejs.org/#countBy).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback

###### Syntax
```php
 countBy(array $array, callable $callable): array
```

###### Example

```php
<?php
$res = Arrays::countBy([1, 2, 3, 4, 5], function($num) {
    return $num % 2 == 0 ? "even": "odd";
});
// [ "odd => 3, "even" => 2 ]
```

### difference
Returns the values from array that are not present in the other arrays.
- [see also](http://underscorejs.org/#difference).

##### Parameters
- `{array} $array` - source array
- `{array} ...$sources` - source arrays

###### Syntax
```php
 difference(array $array, ...$sources): array
```

###### Example

```php
<?php
$res = Arrays::difference([ 1, 2, 3, 4, 5], [5, 2, 10]); // [1, 3, 4]

$res = Arrays::difference(
    ["a" => "green", "b" => "brown", "c" => "blue", "red"],
    ["a" => "green", "yellow", "red"]
);
// [ "b" => "brown", "c" => "blue",  "red" ]
}

```


### findIndex
Find index of the first element matching the condition in `$callable`
- [see also](http://underscorejs.org/#findIndex).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback

###### Syntax
```php
 findIndex(array $array, callable $callable): mixed
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


### first
Get the first value from an array regardless index order and without modifying the array
When passed in array has no element, it returns undefined, unless `$defaultValue` is supplied.
Then it returns $defaultValue (when `$defaultValue` is a callable then the result of its execution)
- [see also](http://underscorejs.org/#first).

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





### groupBy
Split a collection into sets, grouped by the result of running each value through iterator
- [see also](http://underscorejs.org/#groupBy).

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - iteratee callback

###### Syntax
```php
 groupBy(array $array, callable $callable): array
```

###### Example

```php
<?php
$res = Arrays::groupBy([1.3, 2.1, 2.4], function($num) { return floor($num); });
// [1 => [ 1.3 ], 2 => [ 2.1, 2.4 ]]
```


### intersection
Computes the list of values that are the intersection of all the arrays. Each value in the result is present in each of the arrays.
- [see also](http://underscorejs.org/#intersection).

##### Parameters
- `{array} $array` - source array
- `{array} ...$sources` - source arrays

###### Syntax
```php
 intersection(array $array, ...$sources): array
```

###### Example

```php
<?php
$res = Arrays::intersection([1, 2, 3], [101, 2, 1, 10], [2, 1]); // [1, 2]

$res = Arrays::intersection(
    ["a" => "green", "b" => "brown", "c" => "blue", "red"],
    ["a" => "green", "b" => "yellow", "blue", "red"]
); // [ "a" => "green" ]
```

### last
Get the last value from an array regardless index order and without modifying the array
- [see also](http://underscorejs.org/#last).

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

### object
Converts arrays into objects. Pass either a single list of [key, value] pairs, or a list of keys,
and a list of values. If duplicate keys exist, the last value wins.
- [see also](http://underscorejs.org/#shuffle).


##### Parameters
- `{array} $array` - source array
- `{array} [$value]` - values array

###### Syntax
```php
 toObject(array $array): PlainObject
```

###### Example #1

```php
$obj = Arrays::object([ "foo" =>
            [
                "bar" => [
                    "baz" => "BAZ"
                ]
            ]
        ]);
echo $obj->foo->bar->baz; // BAZ
```

###### Example #2

```php
$obj = Arrays::object([["moe", 30], ["larry", 40], ["curly", 50]]);
echo $obj->moe; // 30
echo $obj->larry; // 40
echo $obj->curly; // 50
```

###### Example #3

```php
$obj = Arrays::object(["moe", "larry", "curly"], [30, 40, 50]);
echo $obj->moe; // 30
echo $obj->larry; // 40
echo $obj->curly; // 50
```

### partition
split array into two arrays: one whose elements all satisfy predicate and one whose elements all do not satisfy predicate.
- [see also](http://underscorejs.org/#partition).

##### Parameters
- `{array} $array` - source array
- `callable|string|Closure $callable` - predicate callback

###### Syntax
```php
 partition(array $array, callable $callable): array
```

###### Example

```php
<?php
$res = Arrays::partition([0, 1, 2, 3, 4, 5], function($val) {
    return $val % 2;
}); //  [[1, 3, 5], [0, 2, 4]]

```



### pluck
A convenient version of what is perhaps the most common use-case for map:
extracting a list of property values.
- [see also](http://underscorejs.org/#pluck).

##### Parameters
- `{array} $array` - source array
- `{string} $key` - source property name

###### Syntax
```php
 pluck(array $array, string $key): array
```

###### Example

```php
<?php
 $res = Arrays::pluck([
      ["name" => "moe",   "age" =>  40],
      ["name" => "larry", "age" =>  50],
      ["name" => "curly", "age" =>  60],
  ], "name"); // ["moe, "larry", "curly" ]


```

### result
If the value of the named property is a function then invoke it; otherwise, return it.
- [see also](http://underscorejs.org/#result).

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

### shuffle
Return a shuffled copy of the list
- [see also](http://underscorejs.org/#shuffle).

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

### uniq
Produces a duplicate-free version of the array
- [see also](http://underscorejs.org/#uniq).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 uniq(array $array): array
```

###### Example

```php
<?php
$res = Arrays::uniq([1,2,3,1,1,2]); // [1,2,3]
```

### unzip
The opposite of zip. Given an array of arrays, returns a series of new arrays, the first of which contains all of the first elements in the input arrays, the second of which contains all of the second elements, and so on.
- [see also](http://underscorejs.org/#unzip).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 unzip(array $array): array
```

###### Example

```php
<?php
$res = Arrays::unzip([["moe", 30, true], ["larry", 40, false], ["curly", 50, false]]);
//  [["moe", "larry", "curly"], [30, 40, 50], [true, false, false]]
```

### where
Look through each value in the list, returning an array of all the values that contain all of the key-value pairs listed in $conditions
- [see also](http://underscorejs.org/#where).

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


### zip
Merges together the values of each of the arrays with the values at the corresponding position. Useful when you have separate data sources that are coordinated through matching array indexes.
- [see also](http://underscorejs.org/#zip).

##### Parameters
- `{array} $array` - source array
- `...$sources` - source arrays

###### Syntax
```php
 zip(array $array, ...$sources): array
```

###### Example

```php
<?php
$res = Arrays::zip(
  ["moe", "larry", "curly"],
  [30, 40, 50],
  [true, false, false]
); //  [["moe", 30, true], ["larry", 40, false], ["curly", 50, false]]
```








## Other methods

### replace
Replace (similar to MYSQL REPLACE statement) an element matching the condition in predicate function with the value
If no match found, add the value to the end of array

##### Parameters
- `{array} $array` - source array
- `{callable} $callable` - predicate callback
- `{mixed} $element` - element to replace the match

###### Syntax
```php
 replace(array $array, callable $callable, $element): array
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