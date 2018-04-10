# Booleans extras

## Methods

- Underscore.js-inspired methods
  - [isBoolean](#isBoolean)
  - [chain](#chain)

## Underscore.js-inspired methods

### isBoolean
Determines whether the passed value is a boolean.
- [see also](http://underscorejs.org/#isBoolean)

##### Parameters
- `{mixed} $value` - source

###### Syntax
```php
 isBoolean($source): bool
```

###### Example
```php
<?php
$res = Numbers::isBoolean(true); // true
```


### chain
Returns a wrapped object. Calling methods on this object will continue to return wrapped objects until value is called.

##### Parameters
- `{number} $value` - source

###### Syntax
```php
 chain($value)
```
