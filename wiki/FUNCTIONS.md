# Function extras

## Methods

- JavaScript-inspired methods
  - [apply](#apply)
  - [bind](#bind)
  - [call](#call)
  - [toString](#toString)

- Underscore.js-inspired methods
  - [bind](#bind)
  - [bindAll](#bindAll)
  - [partial](#partial)
  - [memoize](#memoize)
  - [delay](#delay)
  - [throttle](#throttle)
  - [debounce](#debounce)
  - [once](#once)
  - [after](#before)
  - [before](#before)
  - [wrap](#wrap)
  - [negate](#negate)
  - [compose](#compose)
  - [times](#times)
  - [chain](#chain)

> Method `_.defer` is not relevant in in the context of PHP

## JavaScript-inspired methods

### apply
Calls a function with a given this value, and arguments provided as an array
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/apply).


##### Parameters
- `{mixed} $source` - source mixed
- `{object} $context` - new $this
- `{array} $args` - array of arguments

###### Syntax
```php
apply(mixed $source, $context = null, array $args = [])
```

###### Example
```php
<?php
$obj = Arrays::object(["foo" => "FOO"]);
$source = function( $input ){ return $input . "_" . $this->foo; };
$res = Functions::apply($source, $obj, ["BAR"]); // "BAR_FOO"
```


### bind
Creates a new function that, when called, has its this keyword set to the provided value,
with a given sequence of arguments preceding any provided when the new function is called
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/bind).


##### Parameters
- `{mixed} $source` - source mixed
- `{object} $context` - new $this

###### Syntax
```php
bind(mixed $source, $context = null): mixed
```

###### Example
```php
<?php
$obj = Arrays::object(["foo" => "FOO"]);
$source = function( $input ){ return $input . "_" . $this->foo; };
$func = Functions::bind($source, $obj);
echo $func("BAR"); // "BAR_FOO"
```


### call
Calls a function with a given $context value and arguments provided individually.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/call).


##### Parameters
- `{mixed} $source` - source mixed
- `{object} $context` - new $this
- `{array} ...$args` - arguments

###### Syntax
```php
call(mixed $source, $context = null, ...$args)
```

###### Example
```php
<?php
$obj = Arrays::object(["foo" => "FOO"]);
$source = function( $input ){ return $input . "_" . $this->foo; };
$res = Functions::call($source, $obj, "BAR"); // "BAR_FOO"
```


### toString
Returns a mixed representing the source code of the function.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Function/toString).


##### Parameters
- `{mixed} $source` - source mixed

###### Syntax
```php
toString(mixed $source): mixed
```

###### Example
```php
<?php
echo Functions::toString("strlen");
```

```
mixed(112) "Function [ <internal:Core> function strlen ] {

  - Parameters [1] {
    Parameter #0 [ <required> $str ]
  }
}
```

## Underscore.js-inspired methods

### bindAll
Binds a number of methods on the object, specified by $methodNames, to be run in the context of that object whenever they are invoked. Very handy for binding functions that are going to be used as event handlers, which would otherwise be invoked with a fairly useless this. $methodNames are required
- [see also](http://underscorejs.org/#bindAll).


##### Parameters
- `{object} $source` - context object
- `{array} $methodNames` - method names to bind

###### Syntax
```php
 bindAll($obj, ...$methodNames)
```

###### Example
```php
<?php
$foo = (object)[
    "value" => 1,
    "increment" => function(){
        $this->value++;
    },
    "reset" => function(){
        $this->value = 0;
    }
];
Functions::bindAll($foo, "increment", "reset");

($foo->increment)();
echo $foo->value; // 2

($foo->reset)();
echo $foo->value; // 0
```

### partial
Partially apply a function by filling in any number of its arguments
- [see also](http://underscorejs.org/#partial).


##### Parameters
- `{mixed} $source` - source function
- `{array} $boundArgs` - arguments to bind

###### Syntax
```php
 partial(mixed $source, ...$boundArgs): mixed
```

###### Example
```php
<?php
$subtract = function($a, $b) { return $b - $a; };
$sub5 = Functions::partial($subtract, 5);
$res = $sub5(20); // 15
```

### memoize
Memoizes a given function by caching the computed result. Useful for speeding up slow-running computations.
If passed an optional hashFunction
- [see also](http://underscorejs.org/#memoize).


##### Parameters
- `{mixed} $source` - source function
- `{mixed} $hasher` - (optional) hash generator

###### Syntax
```php
memoize($source, $hasher = null): mixed
```

###### Example
```php
<?php
$counter = Functions::memoize("fixtureCounter::increment");
$counter($foo); // 1
$counter($foo); // 1
$counter($bar); // 2
$counter($baz); // 3
```

### delay
Much like setTimeout, invokes function after wait milliseconds. If you pass the optional arguments, they will be forwarded on to the function when it is invoked.
- [see also](http://underscorejs.org/#delay).


##### Parameters
- `{mixed} $source` - source function
- `{int} $wait` - wait time in ms
- `{array} $args` - (optional) arguments to pass into produced function

###### Syntax
```php
 delay(mixed $source, int $wait, ...$args)
```

###### Example
```php
<?php
$counter = Functions::memoize("fixtureCounter::increment");
$counter($foo); // 1
$counter($foo); // 1
$counter($bar); // 2
$counter($baz); // 3
```

### throttle
Creates and returns a new, throttled version of the passed function,
that, when invoked repeatedly, will only actually call the original function at most once per every
wait milliseconds. Useful for rate-limiting events that occur faster than you can keep up with.
- [see also](http://underscorejs.org/#throttle).


##### Parameters
- `{mixed} $source` - source function
- `{int} $wait` - wait time in ms

###### Syntax
```php
 throttle(mixed $source, int $wait)
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::throttle("increment", 20);
$func(); // 1
$func(); // false
usleep(20000);
$func();  // 2
$func();  // false
```


### debounce
Creates and returns a new debounced version of the passed function which will postpone its execution until after wait milliseconds have elapsed since the last time it was invoked
- [see also](http://underscorejs.org/#debounce).


##### Parameters
- `{mixed} $source` - source function
- `{int} $wait` - wait time in ms

###### Syntax
```php
 debounce(mixed $source, int $wait)
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::debounce("increment", 20);
$func(); // false
$func(); // false
usleep(20000);
$func();  // 1
$func();  // false
```

### once
Creates a version of the function that can only be called one time.
Repeated calls to the modified function will have no effect, returning the value
from the original call. Useful for initialization functions, instead of having to set a boolean flag
and then check it later.
- [see also](http://underscorejs.org/#once).


##### Parameters
- `{mixed} $source` - source function

###### Syntax
```php
 once(mixed $source): mixed
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::once("increment");
$func(); // 1
$func(); // 1
$func(); // 1
```

### after
Creates a version of the function that will only be run after being called count times. Useful for grouping
asynchronous responses, where you want to be sure that all the async calls have finished, before proceeding.
- [see also](http://underscorejs.org/#after).


##### Parameters
- `{mixed} $source` - source function
- `{int} $count` - count

###### Syntax
```php
 after(mixed $source, int $count): mixed
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::after("increment", 2);
$func(); // false
$func(); // false
$func(); // 1
```

### before
Creates a version of the function that can be called no more than count times.
The result of the last function call is memoized and returned when count has been reached.
- [see also](http://underscorejs.org/#before).


##### Parameters
- `{mixed} $source` - source function
- `{int} $count` - count

###### Syntax
```php
 before(mixed $source, int $count): mixed
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::before("increment", 2);
$func(); // 1
$func(); // 2
$func(); // 2
```



### wrap
Wraps the first function inside of the wrapper function, passing it as the first argument.
This allows the transforming function to execute code before and after the function runs, adjust the arguments, and execute it conditionally.
- [see also](http://underscorejs.org/#wrap).


##### Parameters
- `{mixed} $source` - source function
- `{mixed} $transformer` - transforming function

###### Syntax
```php
 wrap(mixed $source, mixed $transformer)
```

###### Example
```php
<?php
function increment()
{
    static $count = 0;
    return ++$count;
}
$func = Functions::wrap("increment", function($func){
    return 10 + $func();
});
$func(); // 11
```

### negate
Returns a new negated version of the predicate function.
- [see also](http://underscorejs.org/#negate).


##### Parameters
- `{mixed} $source` - source function

###### Syntax
```php
negate(mixed $source): mixed
```

###### Example
```php
<?php
$func = Functions::negate(function(){ return false; });
$func(): // true
```

### compose
Returns the composition of a list of functions, where each function consumes
the return value of the function that follows. In math terms,
composing the functions `f()`, `g()`, and `h()` produces `f(g(h()))`.
- [see also](http://underscorejs.org/#compose).


##### Parameters
- `{array} $functions` - list of mixeds to compose

###### Syntax
```php
 compose(...$functions): mixed
```

###### Example
```php
<?php
$greet = function(mixed $name){ return "hi: " . $name; };
$exclaim = function(mixed $statement){ return strtoupper($statement) . "!"; };
$welcome = Functions::compose($greet, $exclaim);
$welcome("moe"); // "hi: MOE!"
```


### times
Invokes the given iteratee function n times. Each invocation of iteratee is called with an index argument. Produces an array of the returned values.
- [see also](http://underscorejs.org/#times).


##### Parameters
- `{array} $source` - source function
- `{int} $n` - (optional) invoke function N times
- `{object} $context` - (optional) context object to bind to

###### Syntax
```php
 times(callable $source, int $n = 1, $context = null)
```

###### Example
```php
<?php
$counter = 0;
Functions::times(function($value) use(&$counter){
    $counter += $value;
}, 5); // 15
```

### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{mixed} $value` - source mixed

###### Syntax
```php
 chain(mixed $value): Strings
```

###### Example
```php
<?php
$res = Strings::chain( " 12345 " )
            ->replace("/1/", "5")
            ->replace("/2/", "5")
            ->trim()
            ->substr(1, 3)
            ->value();
echo $res; // "534"
```