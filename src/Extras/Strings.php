<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\AbstractExtras;

/**
 * Class represents type String
 */
class Strings extends AbstractExtras
{

    /**
     * Return part of a string
     *
     * @param string $value
     * @param int $start
     * @param int $length
     * @return string
     */
    public static function substr(string $value, int $start, int $length = null): string
    {
        return \substr($value, $start, $length === null ? \strlen($value) - $start : $length);
    }

    /**
     * Perform a regular expression search and replace
     *
     * @param string $value
     * @param string $pattern
     * @param string $replacement
     * @return string
     */
    public static function replace(string $value, string $pattern, string $replacement): string
    {
        return \preg_replace($pattern, $replacement, $value);
    }

    /**
     * Strip whitespace (or other characters) from the beginning and end of a string
     *
     * @param string $value
     * @param string $mask
     * @return string
     */
    public static function trim(string $value, string $mask = " \t\n\r\0\x0B"): string
    {
        return \trim($value, $mask);
    }
    /**
     * Determine whether a string ends with the characters of a specified string,
     * returning true or false as appropriate.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/endsWith
     *
     * @param string $value
     * @param string $search
     * @return string
     */
    public static function endsWith(string $value, string $search): string
    {
        return \substr($value, -\strlen($search)) === $search;
    }

    /**
     * Determine whether a string begins with the characters of a specified string,
     * returning true or false as appropriate.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/startsWith
     * @param string $value
     * @param string $search
     * @return string
     */
    public static function startsWith(string $value, string $search): string
    {
        return $search !== "" && \strpos($value, $search) === 0;
    }

    /**
     * Determine whether one string may be found within another string, returning true or false as appropriate.     *
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/includes
     * @param string $value
     * @param string $search
     * @param int $position
     * @return string
     */
    public static function includes(string $value, string $search, int $position = 0): string
    {
        return \strpos(\substr($value, $position), $search) !== false;
    }

    /**
     * Remove substring from the string
     * @param string $value
     * @param string $search
     * @return string
     */
    public static function remove(string $value, string $search): string
    {
        return \str_replace($search, "", $value);
    }

    /**
     * Test if target a string
     * @param mixed $target
     * @return bool
     */
    public static function isString($target): bool
    {
        return is_string($target);
    }

    /**
     * Return a string created from the specified sequence of code units.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/fromCharCode
     *
     * @param array $codes
     * @return string
     */
    public static function fromCharCode(...$codes): string
    {
        return \array_reduce($codes, function (string $carry, int $code) {
            $carry .= \chr($code);
            return $carry;
        }, "");
    }

    /**
     * Return a new string consisting of the single UTF-16 code unit located at the specified offset into the string.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/charAt
     *
     * @param string $value
     * @param int $index
     * @return string
     */
    public static function charAt(string $value, int $index = 0): string
    {
        return $value[$index] ?? "";
    }

    /**
     * Returns an integer between 0 and 65535 representing the UTF-16 code unit at the given index
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/charCodeAt
     *
     * @param string $value
     * @param int $index
     * @return string
     */
    public static function charCodeAt(string $value, int $index = 0): int
    {
        return \ord(static::charAt($value, $index));
    }

    /**
     * Concatenates the string arguments to the calling string and returns a new string.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/concat
     *
     * @param string $value
     * @param array $strings
     * @return string
     */
    public static function concat(string $value, ...$strings): string
    {
        return \array_reduce($strings, function (string $carry, string $string) {
            $carry .= $string;
            return $carry;
        }, $value);
    }

    /**
     * Returns the index of the first occurrence of the specified value
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/indexOf
     *
     * @param string $value
     * @param string $searchStr
     * @param int $fromIndex (optional)
     * @return int
     */
    public static function indexOf(string $value, string $searchStr, int $fromIndex = 0): int
    {
        $pos = \strpos($value, $searchStr, $fromIndex);
        return $pos === false ? -1 : $pos;
    }

    /**
     * Returns the index of the last occurrence of the specified value
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/lastIndexOf     *
     *
     * @param string $value
     * @param string $searchStr
     * @param int $fromIndex (optional)
     * @return int
     */
    public static function lastIndexOf(string $value, string $searchStr, int $fromIndex = null): int
    {
        switch (true) {
            // nowhwere to search
            case $fromIndex === 0:
                $pos = false;
                break;
            case $fromIndex === null:
                $pos = \strrpos($value, $searchStr);
                break;
            default:
                $pos = \strrpos($value, $searchStr, -1 * ( $fromIndex + 1 ));
                break;
        }
        return $pos === false ? -1 : $pos;
    }

    /**
     * Returns a number indicating whether a reference string comes before or after or is the same as
     * the given string in sort order
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/localeCompare
     *
     * @param string $value
     * @param string $compareStr
     * @return int
     */
    public static function localeCompare(string $value, string $compareStr): int
    {
        return \strcoll($value, $compareStr);
    }

    /**
     * Retrieves the matches when matching a string against a regular expression.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/match
     *
     * @param string $value
     * @param string $regexp
     * @return null|array
     */
    public static function match(string $value, string $regexp)
    {
        $res = \preg_match_all($regexp, $value, $matches);
        if ($res === 0) {
            return null;
        }
        return $matches[0];
    }

    /**
     * Pad the current string (to right) with a given string (repeated, if needed) so that the resulting string
     * reaches a given length
     *
     * @param string $value
     * @param int $length
     * @param type $padString
     * @return string
     */
    public static function padEnd(string $value, int $length, string $padString = " "): string
    {
        return \str_pad($value, $length, $padString, \STR_PAD_RIGHT);
    }

    /**
     * Pad the current string (to left) with a given string (repeated, if needed) so that the resulting string
     * reaches a given length
     *
     * @param string $value
     * @param int $length
     * @param string $padString
     * @return string
     */
    public static function padStart(string $value, int $length, string $padString = " "): string
    {
        return \str_pad($value, $length, $padString, \STR_PAD_LEFT);
    }

    /**
     * Construct and return a new string which contains the specified number
     * of copies of the string on which it was called, concatenated together.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/repeat
     *
     * @param string $value
     * @param int $count
     * @return string
     */
    public static function repeat(string $value, int $count): string
    {
        return \str_repeat($value, $count);
    }

    /**
     * Splits a string into an array of strings by separating the string into substrings,
     * using a specified separator string to determine where to make each split.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/split
     *
     * @param string $value
     * @param string $delimiter
     * @return array
     */
    public static function split(string $value, string $delimiter): array
    {
        return \explode($delimiter, $value);
    }

    /**
     * Extract a section of a string and returns it as a new string.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/slice
     *
     * @param string $value
     * @param int $beginIndex
     * @param int $endIndex
     * @return string
     */
    public static function slice(string $value, int $beginIndex, int $endIndex = null): string
    {
        if ($endIndex === null) {
            return \substr($value, $beginIndex);
        }
        if ($endIndex < 0) {
            return \substr($value, $beginIndex, \strlen($value) + $endIndex - $beginIndex);
        }
        return \substr($value, $beginIndex, $endIndex - $beginIndex);
    }

    /**
     * Return the part of the string between the start and end indexes, or to the end of the string.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/substring
     *
     * @param string $value
     * @param int $beginIndex
     * @param int $endIndex
     * @return string
     */
    public static function substring(string $value, int $beginIndex, int $endIndex = null): string
    {
        if ($endIndex === null) {
            return \substr($value, $beginIndex);
        }
        if ($endIndex < 0) {
            return \substr($value, $beginIndex, \strlen($value) + $endIndex - $beginIndex);
        }
        // If start > stop, then substring will swap those 2 arguments.
        if ($beginIndex > $endIndex) {
            list($beginIndex, $endIndex) = [$endIndex, $beginIndex];
        }
        return \substr($value, $beginIndex, $endIndex - $beginIndex);
    }

    /**
     * Return the calling string value converted to lower case.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toLowerCase
     *
     * @param string $value
     * @return string
     */
    public static function toLowerCase(string $value): string
    {
        return \strtolower($value);
    }

    /**
     * Return the calling string value converted to upper case.
     * @see https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/toUpperCase
     *
     * @param string $value
     * @return string
     */
    public static function toUpperCase(string $value): string
    {
        return \strtoupper($value);
    }

    /**
     * Start chain
     *
     * @param mixed $target
     * @return Chain
     */
    public static function chain($target)
    {
        if (!static::isString($target)) {
            throw new \InvalidArgumentException("Target must be a string; '" . gettype($target) . "' type given");
        }
        return parent::chain($target);
    }

    /**
     * Escapes a string for insertion into HTML, replacing &, <, >, ", `, and ' characters.
     * @see http://underscorejs.org/#escape
     *
     * @param string $string
     * @return string
     */
    public static function escape(string $string): string
    {
        return \htmlentities($string);
    }

    /**
     * The opposite of escape, replaces &amp;, &lt;, &gt;, &quot;, &#96; and &#x27;
     * with their unescaped counterparts.
     * @see http://underscorejs.org/#unescape
     *
     * @param string $string
     * @return string
     */
    public static function unescape(string $string): string
    {
        return \html_entity_decode($string);
    }

    /**
     * Generate a globally-unique id for client-side models or DOM elements that need one. If prefix is passed, the id will be appended to it.
     *
     * @param string $prefix
     * @return bool
     */
    public static function uniqueId(string $prefix = null): string
    {
        return $prefix === null ? \uniqid() : \uniqid($prefix);
    }
}
