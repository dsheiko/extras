<?php
use Dsheiko\Extras\Arrays;


describe("\\Dsheiko\\Extras\\Arrays (Underscore)", function() {

    beforeEach(function(){
       $this->fixtureStooges = [
           ["name" => "moe",   "age" =>  40],
           ["name" => "larry", "age" =>  50],
           ["name" => "curly", "age" =>  60],
       ];
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

    describe("::uniq", function() {

        it("returns array of unique elements", function() {
            $res = Arrays::uniq([1,2,3,1,1,2]);
            expect(implode(",", $res))->to->equal("1,2,3");
        });
    });


    describe(":intersection", function() {

        it("returns intersection for sequential arrays", function() {
            $res = Arrays::intersection([1, 2, 3], [101, 2, 1, 10], [2, 1]);
            expect(implode(",", $res))->to->equal("1,2");
        });

        it("returns intersection for key-value arrays", function() {
            $res = Arrays::intersection(
                ["a" => "green", "b" => "brown", "c" => "blue", "red"],
                ["a" => "green", "b" => "yellow", "blue", "red"]
            );
            expect($res["a"])->to->equal("green");
        });

    });

    describe(":difference", function() {

        it("returns diffs for sequential arrays", function() {
            $res = Arrays::difference([ 1, 2, 3, 4, 5], [5, 2, 10]);
            expect(implode(",", $res))->to->equal("1,3,4");
        });

        it("returns diffs for key-value arrays", function() {
            $res = Arrays::difference(
                ["a" => "green", "b" => "brown", "c" => "blue", "red"],
                ["a" => "green", "yellow", "red"]
            );
            expect($res["b"])->to->equal("brown");
            expect($res["c"])->to->equal("blue");
            expect($res[0])->to->equal("red");
        });

    });

    describe("::partition", function() {

        it("splits target into 2 arrays (positive and nagative filters)", function() {
            $res = Arrays::partition([0, 1, 2, 3, 4, 5], function($val) {
                return $val % 2;
            });
            expect(implode(",", $res[0]))->to->equal("1,3,5");
            expect(implode(",", $res[1]))->to->equal("0,2,4");
        });

    });


    describe("::pluck", function() {

        it("extract values array", function() {
            $res = Arrays::pluck($this->fixtureStooges, "name");
            expect(implode(",", $res))->to->equal("moe,larry,curly");
        });

    });


     describe("::zip", function() {

        it("merges togather and evenly values of passed in arrays", function() {
            $res = Arrays::zip(
                ["moe", "larry", "curly"],
                [30, 40, 50],
                [true, false, false]
            );
            expect($res[0][0])->to->equal("moe");
            expect($res[0][1])->to->equal(30);
            expect($res[0][2])->to->equal(true);
        });

    });


     describe("::unzip", function() {

        it("does the opposite to ::zip", function() {
            $res = Arrays::unzip([["moe", 30, true], ["larry", 40, false], ["curly", 50, false]]);
            expect(implode(",", $res[0]))->to->equal("moe,larry,curly");
            expect(implode(",", $res[1]))->to->equal("30,40,50");
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

        it("throws when property does not exist", function() {
            expect(function(){
                Arrays::result([], "foo");
            })->to->throw(\InvalidArgumentException::class);
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

    describe('::object', function() {

        it("converts key-value array to plain object", function() {
           $obj = Arrays::object([ "foo" =>
                [
                    "bar" => [
                        "baz" => "BAZ"
                    ]
                ]
            ]);
            expect($obj->foo->bar->baz)->to->equal("BAZ");
        });

        it("converts sequential array to plain object", function() {
           $obj = Arrays::object([["moe", 30], ["larry", 40], ["curly", 50]]);
           expect($obj->moe)->to->equal(30);
           expect($obj->larry)->to->equal(40);
           expect($obj->curly)->to->equal(50);
        });

         it("makes plain object from list of keys and list of values", function() {
           $obj = Arrays::object(["moe", "larry", "curly"], [30, 40, 50]);
           expect($obj->moe)->to->equal(30);
           expect($obj->larry)->to->equal(40);
           expect($obj->curly)->to->equal(50);
        });

    });


     describe('::isMatch', function() {

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
        });

    });


    describe('::findWhere', function() {

        it("returns matching pairs", function() {
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
            $res = Arrays::findWhere($src, [
                "foo" => "FOO",
                "bar" => "BAR",
            ]);
            expect($res)->to->equal($src[0]);
        });

    });

    describe('::reject', function() {

        it("returns not matching pairs", function() {
            $res = Arrays::reject([1, 2, 3, 4, 5, 6], function ($num){
                return $num % 2 == 0;
            });
            expect($res)->to->equal([1,3,5]);
        });

    });

    describe('::invoke', function() {

        it("applys callable on every element of the array", function() {
            $res = Arrays::invoke([[5, 1, 7], [3, 2, 1]], [Arrays::class, "sort"]);
            expect($res[0])->to->equal([1, 5, 7]);
            expect($res[1])->to->equal([1, 2, 3]);
        });

    });

    describe('::max', function() {

        it("finds max without iteratee", function() {
            $res = Arrays::max([1,2,3]);
            expect($res)->to->equal(3);
        });

        it("finds max with iteratee", function() {
            $res = Arrays::max($this->fixtureStooges, function($stooge){
                return $stooge["age"];
            });
            expect($res["age"])->to->equal(60);
            expect($res["name"])->to->equal("curly");
        });

        it("finds max with iteratee and with context", function() {
            $context = (object)["modifier" => -1];
            $res = Arrays::max([
                ["foo" => 1],
                ["foo" => 2]
            ], function($item){
                return $item["foo"] * $this->modifier;
            }, $context);
            expect($res["foo"])->to->equal(1);
        });

    });

    describe('::min', function() {

        it("finds min without iteratee", function() {
            $res = Arrays::min([1,2,3]);
            expect($res)->to->equal(1);
        });

        it("finds min with iteratee", function() {
            $res = Arrays::min($this->fixtureStooges, function($stooge){
                return $stooge["age"];
            });
            expect($res["age"])->to->equal(40);
            expect($res["name"])->to->equal("moe");
        });

        it("finds min with iteratee and with context", function() {
            $context = (object)["modifier" => -1];
            $res = Arrays::min([
                ["foo" => 1],
                ["foo" => 2]
            ], function($item){
                return $item["foo"] * $this->modifier;
            }, $context);
            expect($res["foo"])->to->equal(2);
        });

    });

    describe('::sortBy', function() {

        it("sorts with iteratee", function() {
            $res = Arrays::sortBy([1, 2, 3, 4, 5, 6], function($a){
                return \sin($a);
            });
            expect($res)->to->equal([5, 4, 6, 3, 1, 2]);
        });

        it("sorts with key", function() {
            $res = Arrays::sortBy($this->fixtureStooges, "name");
            expect($res[0]["name"])->to->equal("curly");
            expect($res[1]["name"])->to->equal("larry");
        });

    });

    describe("::countBy", function() {

        it("transforms array", function() {
            $res = Arrays::indexBy($this->fixtureStooges, "age");
            expect($res[40]["name"])->to->equal("moe");
        });
    });

    describe("::sample", function() {

        it("returns value when no count given", function() {
            $res = Arrays::sample([1,2,3]);
            expect(is_array($res))->not->to->be->ok;
        });

        it("returns array when count given", function() {
            $res = Arrays::sample([1,2,3], 3);
            expect(is_array($res))->to->be->ok;
        });

    });


    describe("::size", function() {

        it("returns size of assoc array", function() {
            $res = Arrays::size([
                "one" => 1,
                "two" => 2,
                "three" => 3
            ]);
            expect($res)->to->equal(3);
        });
    });



});

