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

        it("does not fall on ArgumentCountError", function() {
            Arrays::each(["1","2","3"], "trim");
            expect(ArraysTest::mockCallable())->to->equal(6);
        });

    });

    describe("::map", function() {

        it("produces a new array of values by running transformation callback on each element of source array", function() {
            $res = Arrays::map([1,2,3], function($num){ return $num + 1; });
            expect(implode(",", $res))->to->equal("2,3,4");
        });

         it("does not fall on ArgumentCountError", function() {
            $res = Arrays::map([" 1 ","  2  "," 3  "], "trim");
            expect($res)->to->equal(["1","2","3"]);
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


    describe("::entries", function() {

        it("extracts pairs", function() {
            $src = ["foo" => "FOO", "bar" => "BAR"];
            $res = Arrays::entries($src);
            expect($res[0])->to->equal(["foo", "FOO"]);
            expect($res[1])->to->equal(["bar", "BAR"]);
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

    describe("::slice", function() {

        it("slices array with both indeces", function() {
            $src = ["Banana", "Orange", "Lemon", "Apple", "Mango"];
            $res = Arrays::slice($src, 1, 3);
            expect($res)->to->equal(["Orange","Lemon"]);
        });

        it("slices array with only start index", function() {
            $src = ["Banana", "Orange", "Lemon", "Apple", "Mango"];
            $res = Arrays::slice($src, 3);
            expect($res)->to->equal(["Apple", "Mango"]);
        });

        it("slices array with negative end index", function() {
            $src = ["Banana", "Orange", "Lemon", "Apple", "Mango"];
            $res = Arrays::slice($src, 2, -1);
            expect($res)->to->equal(["Lemon", "Apple"]);
        });

    });

    describe("::splice", function() {

        it("removes 0 elements from index 2, and insert drum", function() {
            $src = ["angel", "clown", "mandarin", "sturgeon"];
            $res = Arrays::splice($src, 2, 0, "drum");
            expect($res)->to->equal(["angel", "clown", "drum", "mandarin", "sturgeon"]);
        });

        it("removes 1 element from index 3", function() {
            $src = ["angel", "clown", "drum", "mandarin", "sturgeon"];
            $res = Arrays::splice($src, 3, 1);
            expect($res)->to->equal(["angel", "clown", "drum", "sturgeon"]);
        });

        it("removes 1 element from index 2, and insert trumpet", function() {
            $src = ["angel", "clown", "drum", "sturgeon"];
            $res = Arrays::splice($src, 2, 1, "trumpet");
            expect($res)->to->equal(["angel", "clown", "trumpet", "sturgeon"]);
        });


        it("removes 2 elements from index 0, and insert parrot, anemone and blue", function() {
            $src = ["angel", "clown", "trumpet", "sturgeon"];
            $res = Arrays::splice($src, 0, 2, "parrot", "anemone", "blue");
            expect($res)->to->equal(["parrot", "anemone", "blue", "trumpet", "sturgeon"]);
        });

        it("removes 2 elements from index 2", function() {
            $src = ["angel", "clown", "mandarin", "sturgeon"];
            $res = Arrays::splice($src, -2, 1);
            expect($res)->to->equal(["angel", "clown", "sturgeon"]);
        });

        it("removes all elements after index 2", function() {
            $src = ["angel", "clown", "mandarin", "sturgeon"];
            $res = Arrays::splice($src, 2);
            expect($res)->to->equal(["angel", "clown"]);
        });

    });

     describe("::includes", function() {

        it("tests when element exists", function() {
            $res = Arrays::includes([1, 2, 3], 2);
            expect($res)->to->be->ok;
        });

        it("tests when element does not exist", function() {
            $res = Arrays::includes([1, 2, 3], 4);
            expect($res)->not->to->be->ok;
        });

        it("tests with offset", function() {
            $res = Arrays::includes([1, 2, 3, 5, 6, 7], 2, 3);
            expect($res)->not->to->be->ok;
        });


    });

    describe("::concat", function() {

        it("merges arrays", function() {
            $res = Arrays::concat([1, 2], [3, 4]);
            expect($res)->to->equal([1, 2, 3, 4]);
        });

        it("merges multiple arrays", function() {
            $res = Arrays::concat([1, 2], [3, 4], [5, 6]);
            expect($res)->to->equal([1, 2, 3, 4, 5, 6]);
        });

    });

    describe("::copyWithin", function() {

        it("copies with tartet, begin and end indeces", function() {
            $res = Arrays::copyWithin([1, 2, 3, 4, 5], 0, 3, 4);
            expect($res)->to->equal([4, 2, 3, 4, 5]);
        });

        it("copies with tartet and begin indeces, without end index", function() {
            $res = Arrays::copyWithin([1, 2, 3, 4, 5], 1, 3);
            expect($res)->to->equal([1, 4, 5, 4, 5]);
        });

        it("copies with negative target index", function() {
            $res = Arrays::copyWithin([1, 2, 3, 4, 5], -2);
            expect($res)->to->equal([1, 2, 3, 1, 2]);
        });


    });

    describe("::of", function() {

        it("makes an array from argument list", function() {
            $res = Arrays::of(1, 2, 3);
            expect($res)->to->equal([1, 2, 3]);
        });

    });

    describe("::fill", function() {

        it("operates in case #1", function() {
            $res = Arrays::fill([1, 2, 3], 4);
            expect($res)->to->equal([4, 4, 4]);
        });

        it("operates in case #2", function() {
            $res = Arrays::fill([1, 2, 3], 4, 1);
            expect($res)->to->equal([1, 4, 4]);
        });

        it("operates in case #3", function() {
            $res = Arrays::fill([1, 2, 3], 4, 1, 2);
            expect($res)->to->equal([1, 4, 3]);
        });

        it("operates in case #4", function() {
            $res = Arrays::fill([1, 2, 3], 4, 1, 1);
            expect($res)->to->equal([1, 2, 3]);
        });

    });

     describe("::indexOf", function() {

        it("operates in case #1", function() {
            $src = ["ant", "bison", "camel", "duck", "bison"];
            $res = Arrays::indexOf($src, "bison");
            expect($res)->to->equal(1);
        });

        it("operates in case #2", function() {
            $src = ["ant", "bison", "camel", "duck", "bison"];
            $res = Arrays::indexOf($src, "bison", 2);
            expect($res)->to->equal(4);
        });

        it("operates in case #3", function() {
            $src = ["ant", "bison", "camel", "duck", "bison"];
            $res = Arrays::indexOf($src, "giraffe");
            expect($res)->to->equal(-1);
        });

    });

    describe("::lastIndexOf", function() {

        it("operates in case #1", function() {
            $src = [2, 5, 9, 2];
            $res = Arrays::lastIndexOf($src, 2);
            expect($res)->to->equal(3);
        });

        it("operates in case #2", function() {
            $src = [2, 5, 9, 2];
            $res = Arrays::lastIndexOf($src, 7);
            expect($res)->to->equal(-1);
        });

        it("operates in case #3", function() {
            $src = [2, 5, 9, 2];
            $res = Arrays::lastIndexOf($src, 2, 3);
            expect($res)->to->equal(3);
        });

        it("operates in case #4", function() {
            $src = [2, 5, 9, 2];
            $res = Arrays::lastIndexOf($src, 2, 2);
            expect($res)->to->equal(0);
        });

    });

    describe("::join", function() {

        it("joins elements with separator", function() {
            $src = [1,2,3];
            $res = Arrays::join($src, ":");
            expect($res)->to->equal("1:2:3");
        });

        it("joins elements without separator", function() {
            $src = [1,2,3];
            $res = Arrays::join($src);
            expect($res)->to->equal("1,2,3");
        });

    });

    describe("::pop", function() {

        it("takes element from the tail and changes length", function() {
            $src = [1, 2, 3];
            $res = Arrays::pop($src);
            expect($res)->to->equal(3);
            expect(count($src))->to->equal(2);
        });

    });

    describe("::shift", function() {

        it("takes element from the head and changes length", function() {
            $src = [1, 2, 3];
            $res = Arrays::shift($src);
            expect($res)->to->equal(1);
            expect(count($src))->to->equal(2);
        });

    });

    describe("::unshift", function() {

        it("prepends a single element", function() {
            $src = [1, 2];
            $res = Arrays::unshift($src, 0);
            expect($res)->to->equal([0, 1, 2]);
        });

        it("prepends multiple elements", function() {
            $src = [0, 1, 2];
            $res = Arrays::unshift($src, -2, -1);
            expect($res)->to->equal([-2, -1, 0, 1, 2]);
        });

    });

    describe("::push", function() {

        it("adds element", function() {
            $src = [1,2,3];
            $res = Arrays::push($src, 4);
            expect($res)->to->equal([1, 2, 3, 4]);
        });

    });

    describe("::reverse", function() {

        it("reverses array", function() {
            $src = [1,2,3];
            $res = Arrays::reverse($src);
            expect($res)->to->equal([3, 2, 1]);
        });

    });


    describe("::is", function() {

        it("compare simple sequential arrays #1", function() {
            $a = [1,2,3];
            $b = [1,2,3];
            $res = Arrays::is($a, $b);
            expect($res)->to->be->ok;
        });

        it("compare simple sequential arrays #2", function() {
            $a = [1,2,3];
            $b = [0,2,3];
            $res = Arrays::is($a, $b);
            expect($res)->not->to->be->ok;
        });

        it("compare simple associative arrays #1", function() {
            $a = ["foo" => "FOO", "bar" => "BAR"];
            $b = ["foo" => "FOO", "bar" => "BAR"];
            $res = Arrays::is($a, $b);
            expect($res)->to->be->ok;
        });

        it("compare simple associative arrays #2", function() {
            $a = ["foo" => "FOO", "bar" => "BAR"];
            $b = ["foo" => "FOO", "bar" => "B_R"];
            $res = Arrays::is($a, $b);
            expect($res)->not->to->be->ok;
        });

        it("compare complex arrays #1", function() {
            $a = [[["foo" => "FOO", "bar" => "BAR"]]];
            $b = [[["foo" => "FOO", "bar" => "BAR"]]];
            $res = Arrays::is($a, $b);
            expect($res)->to->be->ok;
        });


    });

     describe("::hasOwnProperty", function() {

        it("returns true if key exists", function() {
            $res = Arrays::hasOwnProperty(["foo" => "FOO"], "foo");
            expect($res)->to->be->ok;
        });

        it("returns false if not", function() {
            $res = Arrays::hasOwnProperty(["foo" => "FOO"], "baz");
            expect($res)->not->to->be->ok;
        });

    });



});

