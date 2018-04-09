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

- JavaScript-inspired methods
    - [charAt](#charAt)
    - [charCodeAt](#charCodeAt)
    - [concat](#concat)
    - [endsWith](#endsWith)
    - [fromCharCode](#fromCharCode)
    - [includes](#includes)
    - [indexOf](#indexOf)
    - [lastIndexOf](#lastIndexOf)
    - [localeCompare](#localeCompare)
    - [match](#match)
    - [padEnd](#padEnd)
    - [padStart](#padStart)
    - [remove](#remove)
    - [repeat](#repeat)
    - [replace](#replace)
    - [slice](#slice)
    - [split](#split)
    - [startsWith](#startsWith)
    - [substr](#substr)
    - [substring](#substring)
    - [toLowerCase](#toLowerCase)
    - [toUpperCase](#toUpperCase)
    - [trim](#trim)
- Underscore.js-inspired methods
    - [escape](#escape)
    - [unescape](#unescape)
    - [chain](#chain)


### charAt
Return a new string consisting of the single UTF-16 code unit located at the specified offset into the string.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/charAt)

##### Parameters
- `{string} $value` - source string
- `{string} $index` - index of target character

###### Syntax
```php
 charAt(string $value, int $index = 0): string
```

###### Example
```php
<?php
$res = Strings::charAt("ABC", 1); // "B"
```

### charCodeAt
Return an integer between 0 and 65535 representing the UTF-16 code unit at the given index
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/charCodeAt)

##### Parameters
- `{string} $value` - source string
- `{string} $index` - index of target character

###### Syntax
```php
 charCodeAt(string $value, int $index = 0): int
```

###### Example
```php
<?php
$res = Strings::charCodeAt("ABC", 0); // 65
```

### concat
Concatenate the string arguments to the calling string and returns a new string.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/concat)

##### Parameters
- `{string} $value` - source string
- `{array} ...$strings` - array of target strings

###### Syntax
```php
 concat(string $value, ...$strings): string
```

###### Example
```php
<?php
$res = Strings::concat("AB", "CD", "EF"); // ABCDEF
```

### endsWith
Determine whether a string ends with the characters of a specified string, returning true or false as appropriate.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/endsWith)

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for

###### Syntax
```php
 endsWith(string $value, string $search): bool
```

###### Example
```php
<?php
$res = Strings::endsWith("12345", "45"); // true
```

### fromCharCode
Return a string created from the specified sequence of code units.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCharCode)

##### Parameters
- `{array} $codes` - array of char codes

###### Syntax
```php
 fromCharCode(...$codes): string
```

###### Example
```php
<?php
$res = Strings::fromCharCode(65, 66, 67); // ABC
```

### includes
* Determine whether one string may be found within another string, returning true or false as appropriate.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes).

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for
- `{int} $position` - optionally, start position

###### Syntax
```php
 includes(string $value, string $search, int $position = 0): bool
```

###### Example
```php
<?php
$res = Strings::includes("12345", "1"); // true
```

### indexOf
Return the index of the first occurrence of the specified value
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/indexOf)

##### Parameters
- `{string} $value` - source value
- `{string} $searchStr` - string to search for
- `{int} $fromIndex` - (optional) index to start with

###### Syntax
```php
 indexOf(string $value, string $searchStr, int $fromIndex = 0): int
```

###### Example
```php
<?php
$res = Strings::indexOf("ABCD", "BC"); // 1
$res = Strings::indexOf("ABCABC", "BC", 3); // 4
```

### lastIndexOf
Return the index of the last occurrence of the specified value
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/lastIndexOf)

##### Parameters
- `{string} $value` - source value
- `{string} $searchStr` - string to search for
- `{int} $fromIndex` - (optional) index to start with

###### Syntax
```php
 lastIndexOf(string $value, string $searchStr, int $fromIndex = 0): int
```

###### Example
```php
<?php
$res = Strings::lastIndexOf("canal", "a"); // 3
$res = Strings::lastIndexOf("canal", "a", 2); // 1
```

### localeCompare
Returns a number indicating whether a reference string comes before or after or is the same as the given string in sort order
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/localeCompare)

##### Parameters
- `{string} $value` - source value
- `{string} $compareStr` - string to compare with

###### Syntax
```php
 localeCompare(string $value, string $compareStr): int
```

###### Example
```php
<?php
\setlocale (LC_COLLATE, 'de_DE');
$res = Strings::localeCompare("a", "c"); // -2
```

### match
Retrieves the matches when matching a string against a regular expression.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/match)

##### Parameters
- `{string} $value` - source value
- `{string} $regexp` - regular expression to match

###### Syntax
```php
 match(string $value, string $regexp): null|array
```

###### Example
```php
<?php
$res = Strings::match("A1B1C1", "/[A-Z]/"); // ["A", "B", "C"]
```

### padEnd
Pad the current string (to right) with a given string (repeated, if needed) so that the resulting string  reaches a given length
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/padEnd)

##### Parameters
- `{string} $value` - source value
- `{int} $length` - padding length
- `{string} $padString` - (optional) a string to pad the source with

###### Syntax
```php
 padEnd(string $value, int $length, string $padString = " "): string
```

###### Example
```php
<?php
$res = Strings::padEnd("abc", 10); // "abc       "
$res = Strings::padEnd("abc", 10, "foo"); // "abcfoofoof"
```

### padStart
Pad the current string (to left) with a given string (repeated, if needed) so that the resulting string reaches a given length
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/padStart)

##### Parameters
- `{string} $value` - source value
- `{int} $length` - padding length
- `{string} $padString` - (optional) a string to pad the source with

###### Syntax
```php
 padStart(string $value, int $length, string $padString = " "): string
```

###### Example
```php
<?php
$res = Strings::padStart("abc", 10); // "       abc"
$res = Strings::padStart("abc", 10, "foo"); // "foofoofabc"
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
$res = Strings::remove("12345", "1"); // "2345"
```

### repeat
Construct and return a new string which contains the specified number
of copies of the string on which it was called, concatenated together.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/repeat).

##### Parameters
- `{string} $value` - source string
- `{int} $count` - An integer between 0 and +∞: [0, +∞), indicating the number of times to repeat the string in the newly-created string that is to be returned

###### Syntax
```php
 repeat(string $value, int $count): string
```

###### Example
```php
<?php
$res = Strings::repeat("abc", 2); // abcabc
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
$res = Strings::replace("12345", "/\d/s", "*"); // "*****"
```

## slice
Extract a section of a string and returns it as a new string.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/slice).

##### Parameters
- `{string} $value` - source string
- `{int} $beginIndex` - the zero-based index at which to begin extraction.
- `{int} $endIndex` - (optional) the zero-based index before which to end extraction. The character at this index will not be included.

###### Syntax
```php
 slice(string $value, int $beginIndex, int $endIndex = null): string
```

See also [Difference between slice and substring](https://stackoverflow.com/questions/2243824/what-is-the-difference-between-string-slice-and-string-substring)

###### Example
```php
<?php
$res = Strings::slice("The morning is upon us.", 1, 8); // "he morn"
```

## split
Splits a string into an array of strings by separating the string into substrings,
using a specified separator string to determine where to make each split.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/split).

##### Parameters
- `{string} $value` - source string
- `{string} $delimiter` - specifies the string which denotes the points at which each split should occur.

###### Syntax
```php
 split(string $value, string $delimiter): array
```

###### Example
```php
<?php
$res = Strings::split("a,b,c", ","); // ["a", "b", "c"]
```

### startsWith
Determine whether a string begins with the characters of a specified string, returning true or false as appropriate.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/startsWith).

##### Parameters
- `{string} $value` - source string
- `{string} $search` - substring to look for

###### Syntax
```php
 startsWith(string $value, string $search): bools
```

###### Example
```php
<?php
$res = Strings::startsWith("12345", "12"); // true
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
$res = Strings::substr("12345", 1, 3); // "234"
```

## substring
Return the part of the string between the start and end indexes, or to the end of the string.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/substring).

##### Parameters
- `{string} $value` - source string
- `{int} $beginIndex` - the zero-based index at which to begin extraction.
- `{int} $endIndex` - (optional) the zero-based index before which to end extraction.

###### Syntax
```php
 substring(string $value, int $beginIndex, int $endIndex = null): string
```

See also [Difference between slice and substring](https://stackoverflow.com/questions/2243824/what-is-the-difference-between-string-slice-and-string-substring)

###### Example
```php
<?php
$value = "Mozilla";
$res = Strings::substring($value, 0, 1); // "M"
$res = Strings::substring($value, 1, 0); // "M"
```

### toLowerCase
Return the calling string value converted to lower case.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toLowerCase).

##### Parameters
- `{string} $value` - source string
- `{string} $mask` - optionally, the stripped characters can also be specified using the  parameter.

###### Syntax
```php
 toLowerCase(string $value): string
```

###### Example
```php
<?php
$res = Strings::toLowerCase("AbC"); // abc
```

### toUpperCase
Return the calling string value converted to upper case.
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toUpperCase).

##### Parameters
- `{string} $value` - source string
- `{string} $mask` - optionally, the stripped characters can also be specified using the  parameter.

###### Syntax
```php
 toUpperCase(string $value): string
```

###### Example
```php
<?php
$res = Strings::toUpperCase("AbC"); // ABC
```

### trim
Strip whitespace (or other characters) from the beginning and end of a string
- [see also](https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/trim).

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
$res = Strings::trim("  12345   "); // "12345"
```



### escape
Escapes a string for insertion into HTML
- [see also](http://underscorejs.org/#escape).

##### Parameters
- `{string} $value` - source string

###### Syntax
```php
 escape(string $string): string
```

###### Example
```php
<?php
$res = Strings::escape("Curly, Larry & Moe"); // "Curly, Larry &amp; Moe"
```


### unescape
The opposite of [escape](#escape)
- [see also](http://underscorejs.org/#unescape).

##### Parameters
- `{string} $value` - source string

###### Syntax
```php
 unescape(string $string): string
```

###### Example
```php
<?php
$res = Strings::unescape("Curly, Larry &amp; Moe"); // "Curly, Larry & Moe"
```


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