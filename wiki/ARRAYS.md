# Dsheiko\Extras\Arrays

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
  - [copyWithin](#copywithin)
  - [each](#each)
  - [entries](#entries) - alias: [pairs](#pairs)
  - [every](#every)
  - [fill](#fill)
  - [filter](#filter)
  - [find](#find)
  - [from](#from)
  - [hasOwnProperty](#hasownproperty)
  - [includes](#includes)
  - [indexOf](#indexof)
  - [is](#is)
  - [join](#join)
  - [keys](#keys)
  - [lastIndexOf](#lastindexof)
  - [map](#map)
  - [of](#of)
  - [pop](#pop)
  - [push](#push)
  - [reduceRight](#reduceright)
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
  - Collections
    - [each](#each)
    - [map](#map)
    - [reduce](#reduce)
    - [reduceRight](#reduceright)
    - [find](#find)
    - [filter](#filter)
    - [where](#where)
    - [findWhere](#findwhere)
    - [reject](#reject)
    - [every](#every)
    - [some](#some)
    - [contains](#contains) - alias: [includes](#includes)
    - [invoke](#invoke)
    - [pluck](#pluck)
    - [max](#max)
    - [min](#min)
    - [sortBy](#sortby)
    - [groupBy](#groupby)
    - [indexBy](#indexby)
    - [countBy](#countby)
    - [shuffle](#shuffle)
    - [sample](#sample)
    - [toArray](#toarray) - alias: [from](#from)
    - [size](#size)
    - [partition](#partition)
  - Arrays
    - [first](#first)
    - [initial](#initial)
    - [last](#last)
    - [rest](#rest)
    - [compact](#compact)
    - [flatten](#flatten)
    - [without](#without)
    - [union](#union)
    - [intersection](#intersection)
    - [difference](#difference)
    - [uniq](#uniq)
    - [zip](#zip)
    - [unzip](#unzip)
    - [object](#object)
    - [indexOf](#indexof)
    - [lastIndexOf](#lastindexof)
    - [sortedIndex](#sortedindex)
    - [findIndex](#findindex)
    - [findLastIndex](#findlastindex)
    - [range](#range)
  - Objects
    - [keys](#keys)
    - [allKeys](#allkeys)
    - [values](#values)
    - [mapObject](#mapobject)
    - [pairs](#pairs)
    - [invert](#invert)
    - [findKey](#findkey)
    - [extend](#extend)
    - [pick](#pick)
    - [omit](#omit)
    - [defaults](#defaults)
    - [tap](./CHAINING.md#tap)
    - [has](#has)
    - [property](#property)
    - [propertyOf](#propertyof)
    - [matcher](#matcher)
    - [isEqual](#isequal)
    - [isMatch](#ismatch)
    - [isEmpty](#isempty)
    - [isArray](#isarray)
    - [isObject](#isobject)
  - Chaining
    - [chain](#chain)

- Other methods
  - [isAssocArray](#isassocarray)
  - [replace](#replace)


> Methods `_.functions`, `_.extendOwn`, `_.clone` are not implemented. Given we consider here JavaScript object as associative array, they are not relevant.

> Method `_.isElement` depends on DOM and therefore is not applicable in PHP context.

> Methods `_.isArguments`, `_.isRegExp`, `_.isUndefined` are not relevant in PHP context

> Methods `_.isFunction`, `_.isString`, `_.isNumber`, `_.isFinite`, `_.isNaN`, `_.isBoolean`, `_.isDate`, `_.isError`, `_.isNull` belong to the corresponded classes `Dsheiko\Extras\Functions`, `Dsheiko\Extras\Strings`, `Dsheiko\Extras\Numbers`, `Dsheiko\Extras\Booleans`, `Dsheiko\Extras\Any`


## JavaScript-inspired methods


### assign
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
- `{mixed} $mixed` - iteratee callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
each(array $array, mixed $mixed)
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
- `{mixed} $mixed` - predicate callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 every(array $array, mixed $mixed): bool
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
- `{callable} $predicate` - predicate callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 filter(array $array, callable $predicate): array
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
- `{callable} $predicate` - predicate callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 find(array $array, callable $predicate)
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
- `{mixed} $key` - the property to test

###### Syntax
```php
 hasOwnProperty(array $array, mixed $key): bool
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
Join all elements of an array into a mixed and returns this mixed.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Array/join).

##### Parameters
- `{array} $array` - source array
- `{mixed} $separator` - (optional) Specifies a mixed to separate each pair of adjacent elements of the array. The separator is converted to a mixed if necessary. If omitted, the array elements are separated with a comma (",").

###### Syntax
```php
 join(array $array, mixed $separator = ",")
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
- `{mixed} $searchValue` - (optional) if specified, then only keys containing these values are returned.

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
- `{mixed} $mixed` - iteratee callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 map(array $array, mixed $mixed): array
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
 of(...$args): array
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
- `{mixed} $mixed` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the mixed. If no initial value is supplied, the first element in the array will be used.

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 reduceRight(array $array, mixed $mixed, $initial = null)
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
- `{mixed} $mixed` - iteratee callback
- `{mixed} $initial` - value to use as the first argument to the first call of the mixed. If no initial value is supplied, the first element in the array will be used.

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 reduce(array $array, mixed $mixed, $initial = null)
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
- `{mixed} $mixed` - predicate callback

###### Callback arguments
- `{mixed} $value` - element value
- `{int} $index` - zero-based element index
- `{array} $array` - source array

###### Syntax
```php
 some(array $array, mixed $mixed): bool
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
- `{mixed} $mixed` - iteratee callback

###### Syntax
```php
 sort(array $array, mixed $mixed = null): array
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






## Underscore.js\Collections methods

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
$listOfPlays = [
    ["title" => "Cymbeline", "author" => "Shakespeare", "year" => 1611],
    ["title" => "The Tempest", "author" => "Shakespeare", "year" => 1611],
    ["title" => "Hamlet", "author" => "Shakespeare", "year" => 1603]
];
$res = Arrays::where($listOfPlays, ["author" => "Shakespeare", "year" => 1611]);
// [
//    ["title" => "Cymbeline", "author" => "Shakespeare", "year" => 1611],
//    ["title" => "The Tempest", "author" => "Shakespeare", "year" => 1611],
// ]
```

### findWhere
Looks through the list and returns the first value that matches all of the key-value
pairs listed in properties.
- [see also](http://underscorejs.org/#findWhere).

##### Parameters
- `{array} $array` - source array
- `{array} $props` - key-value pairs to match

###### Syntax
```php
 findWhere(array $array, array $props)
```

###### Example

```php
<?php
$res = Arrays::findWhere([ [ "foo" => "FOO", "bar" => "BAR" ], [ "baz" => "BAZ" ] ], [ "foo" => "FOO" ]);
// [ "foo" => "FOO", "bar" => "BAR" ]
```

### reject
Return the values in list without the elements that the predicate passes. The opposite of [filter](#filter).
- [see also](http://underscorejs.org/#reject).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 reject(array $array, mixed $predicate)
```

###### Example

```php
<?php
$res = Arrays::reject([1, 2, 3, 4, 5, 6], function ($num){
    return $num % 2 == 0;
}); // [1,3,5]
```

### contains
Returns true if the value is present in the list.
- [see also](http://underscorejs.org/#reject).
- alias: [includes](#includes)

##### Parameters
- `{array} $array` - source array
- `{mixed} $searchElement` - the element to search for
- `{int} $fromIndex` - (optional) the position in this array at which to begin searching for searchElement.

###### Syntax
```php
 contains(array $array, $searchElement, int $fromIndex = null): bool
```

### invoke
Calls the method named by methodName on each value in the list. Any extra arguments passed
to invoke will be forwarded on to the method invocation.
- [see also](http://underscorejs.org/#invoke).

##### Parameters
- `{array} $array` - source array
- `{mixed} $iteratee` - callback to run on every array element
- `{array} ...$args` - (optional) extra arguments to pass in the callback

###### Syntax
```php
 invoke(array $array, mixed $iteratee, ...$args): array
```

###### Example

```php
<?php
$res = Arrays::invoke([[5, 1, 7], [3, 2, 1]], [Arrays::class, "sort"]);
// [ [1, 5, 7], [1, 2, 3] ]
```

### pluck
A convenient version of what is perhaps the most common use-case for map:
extracting a list of property values.
- [see also](http://underscorejs.org/#pluck).

##### Parameters
- `{array} $array` - source array
- `{mixed} $key` - source property name

###### Syntax
```php
 pluck(array $array, mixed $key): array
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

### max
Returns the maximum value in list. If an iteratee function is provided
- [see also](http://underscorejs.org/#max).

##### Parameters
- `{array} $array` - source array
- `{mixed} $iteratee` - (optional) callback to compare array element
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 max(array $array, mixed $iteratee = null, $context = null)
```

###### Example

```php
<?php
$res = Arrays::max([1,2,3]); // 3

$res = Arrays::max([
        ["name" => "moe",   "age" =>  40],
        ["name" => "larry", "age" =>  50],
        ["name" => "curly", "age" =>  60],
    ], function($stooge){
     return $stooge["age"];
    });
// ["name" => "curly", "age" =>  60]

```

### min
Returns the minimum value in list. If an iteratee function is provided
- [see also](http://underscorejs.org/#min).

##### Parameters
- `{array} $array` - source array
- `{mixed} $iteratee` - (optional) callback to compare array element
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 min(array $array, mixed $iteratee = null, $context = null)
```

###### Example

```php
<?php
$res = Arrays::min([1,2,3]); // 1

$res = Arrays::min([
        ["name" => "moe",   "age" =>  40],
        ["name" => "larry", "age" =>  50],
        ["name" => "curly", "age" =>  60],
    ], function($stooge){
     return $stooge["age"];
    });
// ["name" => "moe",   "age" =>  40]

```

### sortBy
Return a (stably) sorted copy of list, ranked in ascending order by the results of
running each value through iteratee. iteratee may also be the mixed name of the property to sort by
- [see also](http://underscorejs.org/#sortBy).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $mixed` - iteratee callback or property
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 sortBy(array $array, $iteratee, $context = null): array
```

###### Example

```php
<?php
$res = Arrays::sortBy([1, 2, 3, 4, 5, 6], function($a){
    return \sin($a);
}); // [5, 4, 6, 3, 1, 2]

$res = Arrays::sortBy([
    ["name" => "moe",   "age" =>  40],
    ["name" => "larry", "age" =>  50],
    ["name" => "curly", "age" =>  60],
], "name");
// [["name" => "curly", "age" =>  60],...]
```

### groupBy
Split a collection into sets, grouped by the result of running each value through iterator
- [see also](http://underscorejs.org/#groupBy).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $mixed` - iteratee callback or property
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 groupBy(array $array, $iteratee, $context = null): array
```

###### Example

```php
<?php
$res = Arrays::groupBy([1.3, 2.1, 2.4], function($num) { return floor($num); });
// [1 => [ 1.3 ], 2 => [ 2.1, 2.4 ]]
```

### indexBy
Given a list, and an iteratee function that returns a key for each element in the list
(or a property name), returns an object with an index of each item.
Just like groupBy, but for when you know your keys are unique.
- [see also](http://underscorejs.org/#indexBy).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $mixed` - iteratee callback or property
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 indexBy(array $array,  $iteratee, $context = null): array
```

###### Example

```php
<?php

$res = Arrays::indexBy([
    ["name" => "moe",   "age" =>  40],
    ["name" => "larry", "age" =>  50],
    ["name" => "curly", "age" =>  60],
], "name");
// [ 40 => ["name" => "moe",   "age" =>  40], ...]
```

### countBy
Sort a list into groups and return a count for the number of objects in each group.
- [see also](http://underscorejs.org/#countBy).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $mixed` - iteratee callback or property
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 countBy(array $array,  $iteratee, $context = null): array
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

### sample
Produce a random sample from the list. Pass a number to return n random elements from the list.
Otherwise a single random item will be returned.
- [see also](http://underscorejs.org/#sample).

##### Parameters
- `{array} $array` - source array
- `{int} $count` - (optional) number of random elements

###### Syntax
```php
 sample(array $array, int $count = null)
```

###### Example

```php
<?php
$res = Arrays::sample([1, 2, 3], 3); // [ 2, 1, 3 ]
```

### toArray
Creates a real Array from the list
- [see also](http://underscorejs.org/#toArray).
- alias: [from](#from).

##### Parameters
- `{ArrayObject|\ArrayIterator|Traversable|Object} $collection` - source collection

###### Syntax
```php
 toArray($collection): array
```

### size
Return the number of values in the list.
- [see also](http://underscorejs.org/#size).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 size(array $array): int
```

###### Example

```php
<?php
$res = Arrays::size([
    "one" => 1,
    "two" => 2,
    "three" => 3
]); // 3
```


### partition
split array into two arrays: one whose elements all satisfy predicate and one whose elements all do not satisfy predicate.
- [see also](http://underscorejs.org/#partition).

##### Parameters
- `{array} $array` - source array
- `mixed|mixed|Closure $mixed` - predicate callback

###### Syntax
```php
 partition(array $array, mixed $mixed): array
```

###### Example

```php
<?php
$res = Arrays::partition([0, 1, 2, 3, 4, 5], function($val) {
    return $val % 2;
}); //  [[1, 3, 5], [0, 2, 4]]

```





## Underscore.js\Arrays methods

### first
Get the first value from an array regardless index order and without modifying the array
When passed in array has no element, it returns undefined, unless `$defaultValue` is supplied.
Then it returns $defaultValue (when `$defaultValue` is a mixed then the result of its execution)
- [see also](http://underscorejs.org/#first).

##### Parameters
- `{array} $array` - source array
- `{mixed} $defaultValue` - (optional) scalar or mixed

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

### initial
Returns everything but the last entry of the array. Especially useful on the arguments object.
Pass count to exclude the last count elements from the result.
- [see also](http://underscorejs.org/#initial).

##### Parameters
- `{array} $array` - source array
- `{int} $count` - (optional) number of elements to remove

###### Syntax
```php
 initial(array $array, int $count = 1): array
```

###### Example
```php
<?php
$res = Arrays::initial([5, 4, 3, 2, 1]); // [5, 4, 3, 2]
//...
$res = Arrays::initial([5, 4, 3, 2, 1], 3); // [5, 4]
```

### last
Get the last value from an array regardless index order and without modifying the array
- [see also](http://underscorejs.org/#last).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 last(array $array)
```

###### Example
```php
<?php
$element = Arrays::last([1, 2, 3]);
```

### rest
Returns the rest of the elements in an array. Pass an index to
return the values of the array from that index onward.
- [see also](http://underscorejs.org/#rest).

##### Parameters
- `{array} $array` - source array
- `{int} $count` - (optional) number of elements to remove

###### Syntax
```php
 rest(array $array, int $count = 1): array
```

###### Example
```php
<?php
$res = Arrays::rest([5, 4, 3, 2, 1]); // [4, 3, 2, 1]
//...
$res = Arrays::rest([5, 4, 3, 2, 1], 3); // [2, 1]
```

### compact
Returns a copy of the array with all falsy values removed.
- [see also](http://underscorejs.org/#compact).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 compact(array $array): array
```

###### Example
```php
<?php
$res = Arrays::compact([0, 1, false, 2, '', 3]); // [1, 2, 3]
```

### flatten
Flattens a nested array (the nesting can be to any depth). If you pass shallow,
the array will only be flattened a single level.
- [see also](http://underscorejs.org/#flatten).

##### Parameters
- `{array} $array` - source array
- `{bool} $shallow` - (optional) when true single level of flattering

###### Syntax
```php
 flatten(array $array, bool $shallow = false): array
```

###### Example
```php
<?php
$res = Arrays::flatten([1, [2], [3, [[4]]]]); // [1, 2, 3, 4]
//...
$res = Arrays::flatten([1, [2], [3, [[4]]]], true); // [1, 2, 3, [[4]]]
```

### without
Returns a copy of the array with all instances of the values removed.
- [see also](http://underscorejs.org/#without).

##### Parameters
- `{array} $array` - source array
- `{array} $values` - values to remove

###### Syntax
```php
 without(array $array, ...$values): array
```

###### Example
```php
<?php
$res = Arrays::without([1, 2, 1, 0, 3, 1, 4], 0, 1); // [2, 3, 4]
```

### union
Computes the union of the passed-in arrays: the list of unique items,
in order, that are present in one or more of the arrays.
- [see also](http://underscorejs.org/#union).

##### Parameters
- `{array} ...$args` - arrays to join

###### Syntax
```php
 union(...$args): array
```

###### Example
```php
<?php
$res = Arrays::union(
    [1, 2, 3],
    [101, 2, 1, 10],
    [2, 1]
); // [1, 2, 3, 101, 10]
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

### object
Converts arrays into objects. Pass either a single list of [key, value] pairs, or a list of keys,
and a list of values. If duplicate keys exist, the last value wins.
- [see also](http://underscorejs.org/#object).


##### Parameters
- `{array} $array` - source array
- `{array} $value` - (optional) values array

###### Syntax
```php
 object(array $array, array $values = null): PlainObject
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


### sortedIndex
Uses a binary search to determine the index at which the value should be inserted into the list in order to
maintain the list's sorted order. If an iteratee function is provided, it will be used to compute the sort
ranking of each value, including the value you pass. The iteratee may also be the mixed
name of the property to sort by
- [see also](http://underscorejs.org/#sortedIndex).

##### Parameters
- `{array} $array` - source array
- `{mixed} $value` - value to insert
- `{mixed|mixed} $iteratee` - (optional) iteratee callback
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 sortedIndex(array $array, $value, $iteratee = null, $context = null): int
```

###### Example #1
```php
<?php
$res = Arrays::sortedIndex([10, 20, 30, 40, 50], 35); // 3
```

###### Example #2
```php
<?php
$stooges = [
    ["name" => "moe",   "age" =>  40],
    ["name" => "larry", "age" =>  50],
    ["name" => "curly", "age" =>  60],
];
$res = Arrays::sortedIndex($stooges, ["name" => "larry", "age" => 50], "age"); // 1
```

### findIndex
Find index of the first element matching the condition in `$mixed`
- [see also](http://underscorejs.org/#findIndex).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $iteratee` - (optional) iteratee callback
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 findIndex(array $array, $iteratee = null, $context = null): int
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

### findLastIndex
Like findIndex but iterates the array in reverse,
returning the index closest to the end where the predicate truth test passes.
- [see also](http://underscorejs.org/#findLastIndex).

##### Parameters
- `{array} $array` - source array
- `{mixed|mixed} $iteratee` - (optional) iteratee callback
- `{object} $context` - (optional) context to bind to

###### Syntax
```php
 findLastIndex(array $array, $iteratee = null, $context = null): int
```

###### Example
```php
<?php
$src = [
    [
        'id' => 1,
        'name' => 'Ted',
        'last' => 'White',
    ],
    [
        'id' => 2,
        'name' => 'Bob',
        'last' => 'Brown',
    ],
    [
        'id' => 3,
        'name' => 'Ted',
        'last' => 'Jones',
    ],
];

$res = Arrays::findLastIndex($src, [ "name" => "Ted" ]); // 2
```

### range
A function to create flexibly-numbered lists of integers, handy for each and map loops. start, if omitted, defaults to 0; step defaults to 1. Returns a list of integers from start (inclusive) to stop (exclusive), incremented (or decremented) by step, exclusive. Note that ranges that stop before they start are considered to be zero-length instead of negative — if you'd like a negative range, use a negative step.
- [see also](http://underscorejs.org/#range).

##### Parameters
- `{int} $start` - start value
- `{int} $end` - (optional) end value
- `{int} $step` - (optional) step value

###### Syntax
```php
 range(int $start, int $end = null, int $step = 1): array
```

###### Example #1
```php
<?php
$res = Arrays::range(10); // [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
```
###### Example #2
```php
<?php
$res = Arrays::range(1, 11); // [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
```
###### Example #3
```php
<?php
$res = Arrays::range(0, 30, 5); // [0, 5, 10, 15, 20, 25]
```
###### Example #4
```php
<?php
$res = Arrays::range(0, -10, -1);
// [0, -1, -2, -3, -4, -5, -6, -7, -8, -9]
```


## Underscore.js\Chaining methods


### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.
- [see also](http://underscorejs.org/#chain).

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







## Underscore.js\Objects methods



### allKeys
Retrieve all the names of object's own and inherited properties.
Given we consider here JavaScript object as associative array, it is an alias of [keys](#keys]
- [see also](http://underscorejs.org/#allKeys).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 allKeys(array $array): array
```

### mapObject
Like map, but for associative arrays. Transform the value of each property in turn.
- [see also](http://underscorejs.org/#mapObject).

##### Parameters
- `{array} $array` - source array
- `{callable} $iteratee` - iteratee function
- `{object} $context` - (optional) context object to bind to

###### Syntax
```php
 mapObject(array $array, callable $iteratee, $context = null): array
```

###### Example

```php
<?php
$res = Arrays::mapObject([
    "start" => 5,
    "end" => 12,
], function($val){
    return $val + 5;
}); // [ "start" => 10, "end" => 17, ]

```

### pairs
Convert an object into a list of [key, value] pairs. Alias of [entries](#entries)
- [see also](http://underscorejs.org/#pairs).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 pairs(array $array): array
```

###### Example

```php
<?php
$res = Arrays::pairs(["foo" => "FOO", "bar" => "BAR"]); // [["foo", "FOO"], ["bar", "BAR"]]

```

### invert
Returns a copy of the object where the keys have become the values and the values the keys. For this to work, all of your object's values should be unique and string serializable.
- [see also](http://underscorejs.org/#invert).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 invert(array $array): array
```

###### Example

```php
<?php
$res = Arrays::invert([
    "Moe" => "Moses",
    "Larry" => "Louis",
    "Curly" => "Jerome",
]);
// [
//    "Moses" => "Moe",
//    "Louis" => "Larry",
//    "Jerome" => "Curly",
// ]

```

### findKey
Similar to [findIndex](#findIndex), but for keys in objects. Returns the key where the predicate truth test passes or undefined
- [see also](http://underscorejs.org/#findKey).

##### Parameters
- `{array} $array` - source array
- `{callable} $iteratee` - iteratee function
- `{object} $context` - (optional) context object to bind to

###### Syntax
```php
 findKey(array $array, $iteratee = null, $context = null): string
```

###### Example

```php
<?php
$src = [
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
];
$res = Arrays::findKey($src, [ "name" => "Ted" ]); // foo

```

### extend
Shallowly copy all of the properties in the source objects over to the destination object, and return the destination object. Any nested objects or arrays will be copied by reference
Given we consider here JavaScript object as associative array, it's an alias of [assign](#assign)
- [see also](http://underscorejs.org/#extend).

##### Parameters
- `{array} ...$arrays` - arrays to merge


###### Syntax
```php
 extend(... $arrays): array
```

###### Example

```php
<?php
$res = Arrays::extend(["foo" => 1, "bar" => 2], ["bar" => 3], ["foo" => 4], ["baz" => 5]);
// ["foo" => 4, "bar" => 3, "baz" => 5]

```

### pick
Return a copy of the object, filtered to only have values for the whitelisted keys (or array of valid keys). Alternatively accepts a predicate indicating which keys to pick.
- [see also](http://underscorejs.org/#pick).

##### Parameters
- `{array} $array` - source array
- `{array} ...$keys` - keys or iteratee function

###### Syntax
```php
 pick(array $array, ...$keys): array
```

###### Example #1

```php
<?php
$res = Arrays::pick([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
  ], 'name', 'age');
// ['name' => 'moe', 'age' => 50, ]

```

###### Example #2

```php
<?php
$res = Arrays::pick([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
], function($value){
    return is_int($value);
});
// ['age' => 50 ]

```

### omit
Return a copy of the object, filtered to omit the blacklisted keys (or array of keys). Alternatively accepts a predicate indicating which keys to omit.
- [see also](http://underscorejs.org/#omit).

##### Parameters
- `{array} $array` - source array
- `{array} ...$keys` - keys or iteratee function

###### Syntax
```php
 omit(array $array, ...$keys): array
```

###### Example #1

```php
<?php
$res = Arrays::omit([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
  ], 'userid');
// ['name' => 'moe', 'age' => 50, ]

```

###### Example #2

```php
<?php
$res = Arrays::omit([
    'name' => 'moe',
    'age' => 50,
    'userid' => 'moe1',
], function($value){
    return is_int($value);
});
// ['name' => 'moe', 'userid' => 'moe1', ]

```


### defaults
Fill in undefined properties in object with the first value present in the following list of defaults objects.
- [see also](http://underscorejs.org/#defaults).

##### Parameters
- `{array} $array` - source array
- `{array} $defaults` - key-value array of defaults

###### Syntax
```php
 defaults(array $array, array $defaults): array
```

###### Example

```php
<?php
$res = Arrays::defaults([
    "flavor" => "chocolate"
 ], [
     "flavor" => "vanilla",
     "sprinkles" => "lots",
 ]); //["flavor" => "chocolate", "sprinkles" => "lots", ]

```

### has
Does the object contain the given key? Identical to object.hasOwnProperty(key), but uses a safe reference to the hasOwnProperty function, in case it's been overridden accidentally.
- [see also](http://underscorejs.org/#has).

##### Parameters
- `{array} $array` - source array
- `{string} $key` - key to look for

###### Syntax
```php
 has(array $array, string $key): bool
```

###### Example

```php
<?php
$res = Arrays::has([
     "flavor" => "vanilla",
     "sprinkles" => "lots",
 ], "flavor"); // true

```

### property
Returns a function that will itself return the key property of any passed-in object.
- [see also](http://underscorejs.org/#property).

##### Parameters
- `{string} $prop` - property name

###### Syntax
```php
 property(string $prop): callable
```

###### Example

```php
<?php
$stooge = [ "name" => "moe" ];
$res = Arrays::property("name")($stooge); // "moe"

```

### propertyOf
Inverse of [property](#property). Takes an object and returns a function which will return the value of a provided property.
- [see also](http://underscorejs.org/#propertyOf).

##### Parameters
- `{array} $array` - source key-value array

###### Syntax
```php
 propertyOf(array $array): callable
```

###### Example

```php
<?php
$stooge = [ "name" => "moe" ];
$res = Arrays::propertyOf($stooge)("name"); // "moe"

```

### matcher
Returns a predicate function that will tell you if a passed in object contains all of the key/value properties present in attrs.
- [see also](http://underscorejs.org/#matcher).

##### Parameters
- `{array} $attrs` - attributes to check

###### Syntax
```php
 matcher(array $attrs): callable
```

###### Example

```php
<?php
$src = [
    [
        "foo" => "FOO",
        "bar" => "BAR",
    ],
    [
        "bar" => "BAR",
        "baz" => "BAZ",
    ]
];
$matcher = Arrays::matcher([
        "foo" => "FOO",
        "bar" => "BAR",
]);
$res = Arrays::filter($src, $matcher);
// [[ "foo" => "FOO", "bar" => "BAR", ]]

```

### isEmpty
Returns true if an enumerable object contains no values (no enumerable own-properties).
- [see also](http://underscorejs.org/#isEmpty).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 isEmpty(array $array): bool
```

###### Example

```php
<?php
  $res = Arrays::isEmpty([]); // true
```

### isEqual
Performs an optimized deep comparison between the two objects, to determine if they should be considered equal.
- [see also](http://underscorejs.org/#isEqual).

##### Parameters
- `{array} $array` - source array
- `{array} $target` - array to compare with

###### Syntax
```php
 isEqual(array $array, array $target): bool
```

###### Example

```php
<?php
$res = Arrays::isEqual([
        "name" => "moe",
        "luckyNumbers" => [13, 27, 34],
        ], [
        "name" => "moe",
        "luckyNumbers" => [13, 27, 34],
]); // true
```

### isMatch
Tells you if the keys and values in properties are contained in object.
- [see also](http://underscorejs.org/#isMatch).

##### Parameters
- `{array} $array` - source key-value array
- `{array} $attrs` - attributes to check

###### Syntax
```php
 isMatch(array $array, array $attrs): bool
```

###### Example

```php
<?php
 $res = Arrays::isMatch([
        "foo" => "FOO",
        "bar" => "BAR",
        "baz" => "BAZ",
    ],
    [
        "foo" => "BAZ",
    ]); // false

```

### isArray
Returns true if source is an array.
- [see also](http://underscorejs.org/#isArray).

##### Parameters
- `{array} $array` - source array

###### Syntax
```php
 isArray(array $array): bool
```

###### Example

```php
<?php
   $res = Arrays::isArray([ 1, 2, 3 ]); // true
```

### isObject
Returns true if value is an Object. Given we consider here JavaScript object as associative array,
it is an alias of [isAssocArray](#isAssocArray)
- [see also](http://underscorejs.org/#isObject).

##### Parameters
- `{mixed} $source` - source

###### Syntax
```php
 isObject($source): bool
```

###### Example

```php
<?php
   $res = Arrays::isObject([ "foo" => 1, "bar" => 1, ]); // true
```

## Other methods

### replace
Replace (similar to MYSQL REPLACE statement) an element matching the condition in predicate function with the value
If no match found, add the value to the end of array

##### Parameters
- `{array} $array` - source array
- `{mixed} $mixed` - predicate callback
- `{mixed} $element` - element to replace the match

###### Syntax
```php
 replace(array $array, mixed $mixed, $element): array
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

