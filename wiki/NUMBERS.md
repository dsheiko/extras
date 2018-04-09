# Number extras

## Methods

- JavaScript-inspired methods
  - [isFinite](#isFinite)
  - [isInteger](#isInteger)
  - [isNaN](#isNaN)
  - [parseFloat](#parseFloat)
  - [parseInt](#parseInt)
  - [toFixed](#toFixed)
  - [toPrecision](#toPrecision)
- Underscore.js-inspired methods
  - [isNumber](#isNumber)
  - [chain](#chain)


## JavaScript-inspired methods

### isFinite
Determines whether the passed value is a finite number.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isFinite)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isFinite($source): bool
```

###### Example
```php
<?php
$res = Numbers::isFinite(log(0)); // true
```

### isInteger
Determines whether the passed value is an integer.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isInteger)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isInteger($source): bool
```

###### Example
```php
<?php
$res = Numbers::isInteger(123); // true
```

### isNaN
Determines whether the passed value is Not a Number.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/isNaN)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isNaN($source): bool
```

###### Example
```php
<?php
$res = Numbers::isNaN(\NAN); // true
```

### parseFloat
Parse source to a float
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/parseFloat)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 parseFloat($source)
```

###### Example #1
```php
<?php
$src = "4.567abcdefgh";
echo Numbers::isNaN(Numbers::parseFloat($src)); // true
```

###### Example #2
```php
<?php
$src = "abcdefgh";
echo Numbers::isNaN(Numbers::parseFloat($src)); // false
```

### parseInt
Parse source to an integer
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/parseInt)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isInteger($source): bool
```

###### Example #1
```php
<?php
$res = Numbers::parseInt("123"); // 123
```

###### Example #2
```php
<?php
$res = Numbers::parseInt("0xF", 16); // 15
```

###### Example #3
```php
<?php
$res = Numbers::parseInt("101110", 2); // 46
```

###### Example #4
```php
<?php
$res = Numbers::parseInt("0xF", 2); // NaN
```


### toFixed
Formats a number using fixed-point notation
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toFixed)

##### Parameters
- `{float} $value` - source
- `{int} $digits` - (optional) the number of digits to appear after the decimal point; this may be a value between 0 and 20

###### Syntax
```php
 toFixed(float $value, int $digits = 0): float
```

###### Example #1
```php
<?php
$res = Numbers::toFixed(12345.6789, 1); // 12345.7
```

###### Example #2
```php
<?php
$res = Numbers::toFixed(12345.6789, 6); // 12345.678900
```

### toPrecision
Returns a string representing the Number object to the specified precision.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Number/toPrecision)

##### Parameters
- `{float} $value` - source
- `{int} $precision` - (optional) an integer specifying the number of significant digits.

###### Syntax
```php
 toPrecision(float $value, int $precision = null): float
```

###### Example #1
```php
<?php
$res = Numbers::toPrecision(5.123456); // 5.123456
```

###### Example #2
```php
<?php
$res = Numbers::toPrecision(5.123456, 5); // 5.1235
```

###### Example #3
```php
<?php
$res = Numbers::toPrecision(5.123456, 2); // 5.1
```

###### Example #4
```php
<?php
$res = Numbers::toPrecision(5.123456, 1); // 5
```


## Underscore.js-inspired methods

### isNumber
Determines whether the passed value is a number.
- [see also](http://underscorejs.org/#isNumber)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isNumber($source): bool
```

###### Example #1
```php
<?php
$res = Numbers::isNumber(1); // true
```

###### Example #2
```php
<?php
$res = Numbers::isNumber(1.1); // true
```


### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{number} $value` - source

###### Syntax
```php
 chain($value)
```
