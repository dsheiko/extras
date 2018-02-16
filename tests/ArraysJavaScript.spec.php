<?php
use Dsheiko\Extras\Arrays;

class ArraysTest
{
    public static $sum = 0;
    public static function mockCallable(int $num = 0): int
    {
        static::$sum += $num;
        return static::$sum;
    }
}

function makeGenearatorArray(): iterable
{
    foreach (range(1, 3) as $i) {
        yield $i;
    }
}

describe("\\Dsheiko\\Extras\\Arrays (JavaScript)", function() {

    describe("::each", function() {

        it("runs array_walk without crashing with `Only variables can be passed by reference`", function() {
            $sum = 0;
            Arrays::each([1,2,3], function ($val) use(&$sum) {
                $sum += $val;
            });
            expect($sum)->to->equal(6);
        });

        it("accepts a string for callable", function() {
            Arrays::each([1,2,3], "ArraysTest::mockCallable");
            expect(ArraysTest::mockCallable())->to->equal(6);
        });

    });

    describe("::map", function() {

        it("produces a new array of values by running transformation callback on each element of source array", function() {
            $res = Arrays::map([1,2,3], function($num){ return $num + 1; });
            expect(implode(",", $res))->to->equal("2,3,4");
        });

    });

    describe("::from", function() {

        it("creates array from array", function() {
            $res = Arrays::from([1,2,3]);
            expect(is_array($res))->to->be->ok;
        });

        it("creates array from ArrayObject", function() {
            $res = Arrays::from(new \ArrayObject([1,2,3]));
            expect(is_array($res))->to->be->ok;
        });

        it("creates array from Iterator", function() {
            $obj = new \ArrayObject([1,2,3]);
            $res = Arrays::from($obj->getIterator());
            expect(is_array($res))->to->be->ok;
        });

        it("creates array from iterable (generator)", function() {
            $res = Arrays::from(makeGenearatorArray());
            expect(is_array($res))->to->be->ok;
        });

        it("creates array from PlainObject", function() {
            $res = Arrays::from(Arrays::object(["foo" => "FOO"]));
            expect(is_array($res))->to->be->ok;
        });

        it("creates array from uncategorized", function() {
            $res = Arrays::from("123");
            expect(is_array($res))->to->be->ok;
        });

    });

    describe("::keys", function() {

        it("returns all keys in assoiative array", function() {
            $res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"]);
            expect($res)->to->equal(["foo", "bar"]);
        });

        it("returns indices in sequential array", function() {
            $res = Arrays::keys([2,3,4]);
            expect($res)->to->equal([0,1,2]);
        });

        it("returns subset of keys matching search value", function() {
            $res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"], "BAR");
            expect($res)->to->equal(["bar"]);
        });

    });

    describe("::reduce", function() {

        it("reduces array to a single value", function() {
            $res = Arrays::reduce([1,2,3], function(int $carry, int $num){ return $carry + $num; }, 0);
            expect($res)->to->equal(6);
        });

    });

    describe("::reduceRight", function() {

        it("reduces array in right-to-left direction", function() {
            $res = Arrays::reduceRight([1,2,3], function(string $carry, int $num){
                return $carry . (string)$num;
            }, "");
            expect($res)->to->equal("321");
        });

    });

    describe("::values", function() {

        it("extracts all the values of the array", function() {
            $res = Arrays::values([ 5 => 1, 10 => 2, 100 => 3]);
            expect($res)->to->equal([1, 2, 3]);
        });

    });

    describe("::sort", function() {

        it("sorts array values", function() {
            $res = Arrays::sort([3,2,1]);
            expect($res)->to->equal([1, 2, 3]);
        });

    });

    describe("::sort", function() {

        it("sorts array values", function() {
            $res = Arrays::sort([3,2,1]);
            expect($res)->to->equal([1, 2, 3]);
        });

        it("sorts array values by using user-defined function", function() {
            $res = Arrays::sort([3,2,1], function($a, $b){
                return $a <=> $b;
            });
            expect($res)->to->equal([1, 2, 3]);
        });

    });

    describe("::assign", function() {

        it("extends target array with source one when both have string keys", function() {
            $res = Arrays::assign(["foo" => 1, "bar" => 2], ["bar" => 3]);
            expect(json_encode($res))->to->equal('{"foo":1,"bar":3}');
        });

        it("extends target array with multiple source ones when both have string keys", function() {
            $res = Arrays::assign(["foo" => 1, "bar" => 2], ["bar" => 3], ["foo" => 4], ["baz" => 5]);
            expect(json_encode($res))->to->equal('{"foo":4,"bar":3,"baz":5}');
        });

        it("extends target array with source one when both have numeric keys", function() {
            $res = Arrays::assign([1 => "foo", 2 => "bar"], [2 => "baz"]);
            expect(json_encode($res))->to->equal('{"1":"foo","2":"baz"}');
        });

        it("throws exception when target not an associative array", function() {
            expect(function(){
                Arrays::assign([1, 2], [2 => "baz"]);
            })->to->throw(\InvalidArgumentException::class);
        });

        it("throws exception when source not an associative array", function() {
            expect(function(){
                Arrays::assign([2 => "baz"], [1, 2]);
            })->to->throw(\InvalidArgumentException::class);
        });

        it("throws exception when source not an array", function() {
            expect(function(){
                Arrays::assign([2 => "baz"], 2);
            })->to->throw(\InvalidArgumentException::class);
        });

    });

    describe("::filter", function() {

        it("filters elements compling callback condition", function() {
            $res = Arrays::filter([1,2,3], function(int $num){ return $num > 1; });
            sort($res);
            expect($res)->to->equal([2,3]);
        });

        it("filters nullable when no callback given", function() {
            $res = Arrays::filter([1, null, 2, 0, 3]);
            sort($res);
            expect($res)->to->equal([1,2,3]);
        });

    });

    describe("::find", function() {

        it("finds the first element of filtered array", function() {
            $res = Arrays::find([1,2,3], function(int $num){ return $num > 1; });
            expect($res)->to->equal(2);
        });

    });

    describe("::some", function() {

        it("returns true when at least one element complies the callback condition", function() {
            $res = Arrays::some([1,2,3], function(int $num){ return $num > 1; });
            expect($res)->to->be->ok;
        });

        it("returns false when no elements comply the callback condition", function() {
            $res = Arrays::some([1,2,3], function(int $num){ return $num > 100; });
            expect($res)->not->to->be->ok;
        });

    });

    describe("::every", function() {

        it("returns true when all elements comply the callback condition", function() {
            $res = Arrays::every([1,2,3], function(int $num){ return $num > 0; });
            expect($res)->to->be->ok;
        });

        it("returns false when not all elements comply the callback condition", function() {
            $res = Arrays::every([1,2,3], function(int $num){ return $num > 1; });
            expect($res)->not->to->be->ok;
        });

    });


});

