# String extras

## Overview example

```php
<?php
$res = Strings::from( " 12345 " )
            ->replace("/1/", "5")
            ->replace("/2/", "5")
            ->trim()
            ->substr(1, 3)
            ->get();
echo $res; // "534"
```

## Methods

- [chain](#chain)
- [endsWith](#endsWith)
- [includes](#includes)
- [remove](#remove)
- [replace](#replace)
- [startsWith](#startsWith)
- [substr](#substr)
- [trim](#trim)


### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{string} $value` - source string

###### Syntax
```php
 chain(string $value): Strings
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

### endsWith
Determine whether a string ends with the characters of a specified string, returning true or false as appropriate.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/endsWith)

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for

###### Syntax
```php
 endsWith(string $value, string $search): string
```

###### Example
```php
<?php
$res = Strings::endsWith("12345", "45");
```

### includes
* Determine whether one string may be found within another string, returning true or false as appropriate.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes).

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for
- `{int} $position` - optionally, start position

###### Syntax
```php
 includes(string $value, string $search, int $position = 0): string
```

###### Example
```php
<?php
$res = Strings::includes("12345", "1");
```



### remove
Remove substring from the string

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for

###### Syntax
```php
 remove(string $value, string $search): string
```

###### Example
```php
<?php
$res = Strings::remove("12345", "1");
```

### replace
Perform a regular expression search and replace

##### Parameters
- `{string} $value` - source string
- `{string} $pattern` - the pattern to search for. It can be either a string or an array with strings.
- `{string} $replacement` - the string or an array with strings to replace.

###### Syntax
```php
 replace(string $value, string $pattern, string $replacement): string
```

###### Example
```php
<?php
$res = Strings::replace("12345", "/\d/s", "*");
```


### startsWith
Determine whether a string begins with the characters of a specified string, returning true or false as appropriate.
[see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/startsWith).

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for

###### Syntax
```php
 startsWith(string $value, string $search): string
```

###### Example
```php
<?php
$res = Strings::startsWith("12345", "12");
```


### substr
Return part of a string

##### Parameters
- `{string} $value` - source string
- `{int} $start` - start position
- `{int} $length` - If length is given and is positive, the string returned will contain at most length characters beginning from start (depending on the length of string).

###### Syntax
```php
 substr(string $value, int $start, int $length = null): string
```

###### Example
```php
<?php
$res = Strings::substr("12345", 1, 3);
```


### trim
Strip whitespace (or other characters) from the beginning and end of a string

##### Parameters
- `{string} $value` - source string
- `{string} $mask` - optionally, the stripped characters can also be specified using the  parameter.

###### Syntax
```php
 trim(string $value, string $mask = " \t\n\r\0\x0B"): string
```

###### Example
```php
<?php
$res = Strings::trim("  12345   ");
```






