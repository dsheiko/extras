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

describe("\\Dsheiko\\Extras\\Arrays", function() {

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

    });

    describe("::keys", function() {

        it("returns all keys", function() {
            $res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"]);
            expect(implode(",", $res))->to->equal("foo,bar");
        });

        it("returns subset of keys matching search value", function() {
            $res = Arrays::keys(["foo" => "FOO", "bar" => "BAR"], "BAR");
            expect(implode(",", $res))->to->equal("bar");
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
            expect(implode(",", $res))->to->equal("2,3");
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

    describe("::first", function() {

        it("returns first element", function() {
            $arr = [1,2,3];
            $res = Arrays::first($arr);
            expect($res)->to->equal(1);
        });

        it("returns default value when source array empty", function() {
            $arr = [];
            $res = Arrays::first($arr, 9);
            expect($res)->to->equal(9);
        });

        it("returns default value produced by given function when source array empty", function() {
            $arr = [];
            $res = Arrays::first($arr, function(){ return 9; });
            expect($res)->to->equal(9);
        });

    });

    describe("::last", function() {

        it("returns last element", function() {
            $arr = [1,2,3];
            $res = Arrays::last($arr);
            expect($res)->to->equal(3);
        });
    });

    describe("::where", function() {

        it("returns elements compling callback condition", function() {
            $arr = ["foo" => "FOO", "bar" => "BAR", "baz" => "BAZ"];
            $res = Arrays::where($arr, ["foo" => "FOO", "bar" => "BAR"]);
            expect(implode(",", array_keys($res)))->to->equal("foo,bar");
        });

         it("returns still an array when matches found", function() {
            $arr = ["foo" => "FOO", "bar" => "BAR", "baz" => "BAZ"];
            $res = Arrays::where($arr, ["foo" => "BAR"]);
            expect($res)->to->be->a("array");
        });

    });

    describe("::groupBy", function() {

        it("splits collection into sets", function() {
            $res = Arrays::groupBy([1.3, 2.1, 2.4], function($num) { return floor($num); });
            expect(json_encode($res))->to->equal('{"1":[1.3],"2":[2.1,2.4]}');
        });
    });

    describe("::countBy", function() {

        it("it sorts a list into groups and returns a count for the number of objects in each group.", function() {
            $res = Arrays::countBy([1, 2, 3, 4, 5], function($num) {
                return $num % 2 == 0 ? "even": "odd";
            });
            expect(json_encode($res))->to->equal('{"odd":3,"even":2}');
        });
    });

    describe("::shuffle", function() {

        it("returns a shuffled copy of the list", function() {
            $res = Arrays::shuffle([1, 2, 3, 4, 5]);
            expect(implode(",", $res))->not->to->equal("1,2,3,4,5");
        });
    });

    describe("::pairs", function() {

        it("returns pairs of keys and values", function() {
            $res = Arrays::pairs([
                "foo" => "FOO",
                "bar" => "BAR",
            ]);
            expect(json_encode($res))->to->equal('[["foo","FOO"],["bar","BAR"]]');
        });
    });

    describe("::result", function() {

        it("returns result of a scalar", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function(){ return "BAR"; },
            ];
            $res = Arrays::result($options, "foo");
            expect($res)->to->equal("FOO");
        });

        it("returns result of a callable", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function(){ return "BAR"; },
            ];
            $res = Arrays::result($options, "bar");
            expect($res)->to->equal("BAR");
        });

    });

    describe('::findIndex', function() {

        it("finds the index of matching element", function() {
           $inx = Arrays::findIndex([
                ["val" => "FOO"],
                ["val" => "BAR"],
            ], function ($item){
                return $item["val"] === "BAR";
            });
            expect($inx)->to->equal(1);
        });

    });

    describe('::toObject', function() {

        it("converts array to plain object", function() {
           $obj = Arrays::toObject([ "foo" =>
                [
                    "bar" => [
                        "baz" => "BAZ"
                    ]
                ]
            ]);
            expect($obj->foo->bar->baz)->to->equal("BAZ");
        });

    });

    describe('::isAssocArray', function() {

        it("returns true for pure associative array", function() {
            $res = Arrays::isAssocArray([ "foo" => 1, "bar" => 1, ]);
            expect($res)->to->be->ok;
        });

        it("returns true for mixed associative/sequential array", function() {
            $res = Arrays::isAssocArray([ "foo" => 1, "bar" => 1, 2, 3 ]);
            expect($res)->to->be->ok;
        });

        it("returns true for pure sequential array", function() {
            $res = Arrays::isAssocArray([ 1, 2, ]);
            expect($res)->not->to->be->ok;
        });

    });

    describe('::replace', function() {

        it("replaces the element matching the predicate function", function() {
           $array = Arrays::replace([
                ["val" => "FOO"],
                ["val" => "BAR"],
            ], function ($item){
                return $item["val"] === "BAR";
            }, ["val" => "BAZ"]);
            expect($array[1]["val"])->to->equal("BAZ");
        });

        it("appends the element to the array if none matching the predicate function found", function() {
           $array = Arrays::replace([
                ["val" => "FOO"],
                ["val" => "BAR"],
            ], function ($item){
                return $item["val"] === "BAZ";
            }, ["val" => "BAZ"]);
            expect($array[2]["val"])->to->equal("BAZ");
        });

    });

    describe('::chain', function() {

        it("chains different methods", function() {
           $res = Arrays::chain([1,2,3])
            ->map(function($num){ return $num + 1; })
            ->map(function($num){ return $num + 1; })
            ->value();
            expect(implode(",", $res))->to->equal("3,4,5");
        });

    });


});

