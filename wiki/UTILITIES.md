# Utils

## Methods

- [identity](#identity)
- [constant](#constant)
- [noop](#noop)
- [random](#random)
- [iteratee](#iteratee)
- [uniqueId](#uniqueId)
- [now](#now)

> Methods `_.noConflict`, `_.mixin` and  `_.template` are not relevant in the context of PHP

> Methods `_.escape` and `_.unescape` belong to `Dsheiko\Extras\Strings`

> Method `_.times` belongs to `Dsheiko\Extras\Functions`

### identity
Returns the same value that is used as the argument. In math: `f(x) = x`
This function looks useless, but is used throughout Underscore as a default iteratee.
- [see also](http://underscorejs.org/#identity)


###### Syntax
```php
 identity(): callable
```

###### Example
```php
<?php
$res = Utils::identity();
$res(42); // 42
```

### constant
Creates a function that returns the same value that is used as the argument of the method
- [see also](http://underscorejs.org/#constant)


##### Parameters
- `{mixed} $value` - arbitrary argument

###### Syntax
```php
 constant($value): callable
```

###### Example
```php
<?php
$res = Utils::constant(42);
$res(1, 2, 3); // 42
```


### noop
Returns null irrespective of the arguments passed to it. Useful as the default for optional callback arguments.
- [see also](http://underscorejs.org/#noop)

##### Parameters
- `{array} ...$args` (optional)

###### Syntax
```php
 noop(...$args)
```

###### Example
```php
<?php
$res = Utils::noop(1,2,3); // null
```


### random
Returns a random integer between min and max, inclusive. If you only pass one argument, it will return a number between 0 and that number
- [see also](http://underscorejs.org/#noop)

##### Parameters
- `{int} $min`
- `{int} $max` (optional)

###### Syntax
```php
 random(int $min , int $max = null)
```

###### Example
```php
<?php
$res = Utils::random(100); // 42
$res = Utils::random(5, 10); // 7
```


### iteratee
Generates a callback that can be applied to each element in a collection.
- [see also](http://underscorejs.org/#iteratee)

##### Parameters
- `{mixed} $value`
- `{object} $context` (optional) context object to bind to

###### Syntax
```php
 iteratee($value, $context = null): callable
```

###### Example #1
```php
<?php
// return identity() for null
$res = Utils::iteratee(null);
$res(1); // 1

```

###### Example #2
```php
<?php
// return matcher() for an array
$macther = Utils::iteratee(["foo" => "FOO"]);
$res = Arrays::find([["foo" => "FOO"]], $macther); // ["foo" => "FOO"]

```

###### Example #3
```php
<?php
// return normalized callablefor a callable
$res = Utils::iteratee(function(){ return 42; });
$res(); // 42

```

###### Example #4
```php
<?php
// bind callable for a context
$obj = (object)["value" => 42];
$res = Utils::iteratee(function(){ return $this->value; }, $obj);
$res(); // 42

```

###### Example #5
```php
<?php
// return property() for other types
$res = Utils::iteratee("foo");
$res(["foo" => "FOO"]); // "FOO"

```

### uniqueId
Generate a globally-unique id for client-side models or DOM elements that need one. If prefix is passed, the id will be appended to it.
- [see also](http://underscorejs.org/#uniqueId)

##### Parameters
- `{string} $prefix` (optional)

###### Syntax
```php
 uniqueId(string $prefix = null): string
```

###### Example #1
```php
<?php
$res = Utils::uniqueId(); // "5acb4ab426fc9"
```

###### Example #2
```php
<?php
$res = Utils::uniqueId("contact_"); // "contact_5acb4ab427262"
```

### result
If the value of the named property is a function then invoke it with the object as context; otherwise, return it. If a default value is provided and the property doesn't exist or is undefined then the default will be returned. If defaultValue is a function its result will be returned.
- [see also](http://underscorejs.org/#result)

##### Parameters
- `{array} $array` - source key-value array
- `{string} $prop` - property name

###### Syntax
```php
 result(array $array, string $prop)
```

###### Example
```php
<?php
$options = [
    "foo" => "FOO",
    "bar" => function() {
        return "BAR";
    },
];
echo Utils::result($options, "foo"); // "FOO"
echo Utils::result($options, "bar"); // "BAR"
```

### now
Returns an integer timestamp for the current time
- [see also](http://underscorejs.org/#now)


###### Syntax
```php
 now(): int
```

###### Example
```php
<?php
echo Utils::now(); // 1392066795351

```