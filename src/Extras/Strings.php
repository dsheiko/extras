<?php
namespace Dsheiko\Extras;

use Dsheiko\Extras\Lib\AbstractExtras;

/**
 * String::from("source")
 *  ->replace("/s/", "S")
 *  ->replace("/o/", "O")
 *  ->trim()
 *  ->strlen(0, 10)
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
        return \substr($value, $start, $length === null ? strlen($value) - $start : $length);
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
}
