<?php
use Dsheiko\Extras\Arrays;

describe("\\Dsheiko\\Extras\\Arrays (Underscore\Objects)", function() {

    beforeEach(function() {
        $this->fixtureStooges = [
            ["name" => "moe", "age" => 40],
            ["name" => "larry", "age" => 50],
            ["name" => "curly", "age" => 60],
        ];
    });

    describe("::allKeys", function() {

        it("returns keys", function() {
            $res = Arrays::allKeys([
                    "foo" => "FOO",
                    "bar" => "BAR",
            ]);
            expect($res)->to->equal(["foo", "bar"]);
        });
    });

    describe("::mapObject", function() {

        it("returns transformed array keeping the keys", function() {
            $res = Arrays::mapObject([
                    "start" => 5,
                    "end" => 12,
            ], function($val){
                return $val + 5;
            });
            expect($res["start"])->to->equal(10);
            expect($res["end"])->to->equal(17);
        });
    });

    describe("::pairs", function() {

        it("extracts pairs", function() {
            $src = ["foo" => "FOO", "bar" => "BAR"];
            $res = Arrays::pairs($src);
            expect($res[0])->to->equal(["foo", "FOO"]);
            expect($res[1])->to->equal(["bar", "BAR"]);
        });

    });

    describe("::invert", function() {

        it("swaps keys and values", function() {
            $res = Arrays::invert([
                "Moe" => "Moses",
                "Larry" => "Louis",
                "Curly" => "Jerome",
              ]);
            expect($res["Moses"])->to->equal("Moe");
            expect($res["Louis"])->to->equal("Larry");
            expect($res["Jerome"])->to->equal("Curly");

        });
    });

    describe("::findKey", function() {

        it("finds key", function() {
            $src = [
                "foo" => [
                    'name' => 'Ted',
                    'last' => 'White',
                ],
                "bar" => [
                    'name' => 'Frank',
                    'last' => 'James',
                ],
                "baz" => [
                    'name' => 'Ted',
                    'last' => 'Jones',
                ],
            ];
            $res = Arrays::findKey($src, [ "name" => "Ted" ]);
            expect($res)->to->equal("foo");
        });

        it("throws when a sequential array supplied", function() {
            $src = [
                [
                    'name' => 'Ted',
                    'last' => 'White',
                ],
                [
                    'name' => 'Frank',
                    'last' => 'James',
                ],
                [
                    'name' => 'Ted',
                    'last' => 'Jones',
                ],
            ];
            expect(function() use($src) {
                Arrays::findKey($src, [ "name" => "Ted" ]);
            })->to->throw(\InvalidArgumentException::class);
        });

    });

    describe("::extend", function() {

        it("extends target array with multiple source ones when both have string keys", function() {
            $res = Arrays::extend(["foo" => 1, "bar" => 2], ["bar" => 3], ["foo" => 4], ["baz" => 5]);
            expect(json_encode($res))->to->equal('{"foo":4,"bar":3,"baz":5}');
        });

    });

    describe("::pick", function() {

        it("returns as is when empty", function() {
            $res = Arrays::pick([], 'name', 'age');
            expect($res)->to->equal([]);
        });

        it("filters array by key list", function() {
            $res = Arrays::pick([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
              ], 'name', 'age');
            expect(json_encode($res))->to->equal('{"name":"moe","age":50}');
        });

         it("filters array by predicate", function() {
            $res = Arrays::pick([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
              ], function($value){
                return is_int($value);
              });
            expect(json_encode($res))->to->equal('{"age":50}');
        });
    });

    describe("::omit", function() {

        it("returns as is when empty", function() {
            $res = Arrays::omit([], 'name', 'age');
            expect($res)->to->equal([]);
        });

        it("filters array by key list", function() {
            $res = Arrays::omit([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
              ], 'userid');
            expect(json_encode($res))->to->equal('{"name":"moe","age":50}');
        });

         it("filters array by predicate", function() {
            $res = Arrays::omit([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
              ], function($value){
                return is_int($value);
              });
            expect(json_encode($res))->to->equal('{"name":"moe","userid":"moe1"}');
        });
    });

    describe("::defaults", function() {

        it("returns extended array", function() {
            $res = Arrays::defaults([
                   "flavor" => "chocolate"
            ], [
                "flavor" => "vanilla",
                "sprinkles" => "lots",
            ]);
            expect(json_encode($res))->to->equal('{"flavor":"chocolate","sprinkles":"lots"}');
        });
    });

    describe("::property", function() {

        it("returns", function() {
            $stooge = [ "name" => "moe" ];
            $res = Arrays::property("name")($stooge);
            expect($res)->to->equal("moe");
        });

    });

    describe("::propertyOf", function() {

        it("returns", function() {
            $stooge = [ "name" => "moe" ];
            $res = Arrays::propertyOf($stooge)("name");
            expect($res)->to->equal("moe");
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

    describe('::isMatch', function() {

        it("returns false empty", function() {
            $res = Arrays::isMatch([], []);
            expect($res)->to->equal(false);
        });

        it("returns true when array and conditions map equal ", function() {
            $res = Arrays::isMatch([
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
                    ], [
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
            ]);
            expect($res)->to->be->ok;
        });

        it("returns true when some of array pairs match conditions map", function() {
            $res = Arrays::isMatch([
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
                    ], [
                    "foo" => "FOO",
            ]);
            expect($res)->to->be->ok;
        });

        it("returns false when none of array pairs match conditions map", function() {
            $res = Arrays::isMatch([
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
                    ], [
                    "foo" => "BAZ",
            ]);
            expect($res)->not->to->be->ok;
        });

        it("returns false when at least one of conditions not matched in the array", function() {
            $res = Arrays::isMatch([
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
                    ], [
                    "foo" => "FOO",
                    "bar" => "QUIZ",
                    "baz" => "BAZ",
            ]);
            expect($res)->not->to->be->ok;
        });
    });

    describe('::matcher', function() {

        it("returns predicate function", function() {
            $matcher = Arrays::matcher([
                    "foo" => "FOO",
                    "bar" => "BAR",
            ]);
            $src = [
                [
                    "foo" => "FOO",
                    "bar" => "BAR",
                    "baz" => "BAZ",
                ],
                [
                    "bar" => "BAR",
                    "baz" => "BAZ",
                ],
                [
                    "baz" => "BAZ",
                ]
            ];
            $res = Arrays::filter($src, $matcher);
            expect($res[0])->to->equal($src[0]);
            expect(count($res))->to->equal(1);
        });
    });

    describe('::isEqual', function() {

        it("returns true when arrays are equal ", function() {
            $res = Arrays::isEqual([
                    "name" => "moe",
                    "luckyNumbers" => [13, 27, 34],
                    ], [
                    "name" => "moe",
                    "luckyNumbers" => [13, 27, 34],
            ]);
            expect($res)->to->be->ok;
        });
        it("returns false when arrays are not equal ", function() {
            $res = Arrays::isEqual([
                    "name" => "moe",
                    "luckyNumbers" => [13, 27, 34, 1],
                    ], [
                    "name" => "moe",
                    "luckyNumbers" => [13, 27, 34],
            ]);
            expect($res)->not->to->be->ok;
        });

    });

    describe('::isEmpty', function() {

        it("returns false when seq. array is not empty", function() {
            $res = Arrays::isEmpty([1, 2, 3]);
            expect($res)->not->to->be->ok;
        });

         it("returns false when assoc. array is not empty", function() {
            $res = Arrays::isEmpty(["foo" => "FOO"]);
            expect($res)->not->to->be->ok;
        });

        it("returns true when source array is empty", function() {
            $res = Arrays::isEmpty([]);
            expect($res)->to->be->ok;
        });

    });

    describe('::isObject', function() {

        it("returns true for pure associative array", function() {
            $res = Arrays::isObject([ "foo" => 1, "bar" => 1, ]);
            expect($res)->to->be->ok;
        });

    });

    describe('::isArray', function() {

        it("returns true for assoc. array", function() {
            $res = Arrays::isArray([ "foo" => 1, "bar" => 1, ]);
            expect($res)->to->be->ok;
        });

        it("returns true for seq. array", function() {
            $res = Arrays::isArray([ 1, 2, 3 ]);
            expect($res)->to->be->ok;
        });

        it("returns false for string", function() {
            $res = Arrays::isArray("..");
            expect($res)->not->to->be->ok;
        });

    });
});

