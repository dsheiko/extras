<?php
use Dsheiko\Extras\Arrays;

describe("\\Dsheiko\\Extras\\Arrays (Underscore\Arrays)", function() {

    beforeEach(function() {
        $this->fixtureStooges = [
            ["name" => "moe", "age" => 40],
            ["name" => "larry", "age" => 50],
            ["name" => "curly", "age" => 60],
        ];
    });


    describe("::first", function() {

        it("returns first element", function() {
            $arr = [1, 2, 3];
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
            $res = Arrays::first($arr, function() {
                    return 9;
                });
            expect($res)->to->equal(9);
        });
    });

    describe("::last", function() {

        it("returns last element", function() {
            $arr = [1, 2, 3];
            $res = Arrays::last($arr);
            expect($res)->to->equal(3);
        });

        it("returns default value produced by given function when source array empty", function() {
            $arr = [];
            $res = Arrays::last($arr, function() {
                    return 9;
                });
            expect($res)->to->equal(9);
        });
    });

    describe("::uniq", function() {

        it("returns array of unique elements", function() {
            $res = Arrays::uniq([1, 2, 3, 1, 1, 2]);
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
                    ["a" => "green", "b" => "brown", "c" => "blue", "red"], ["a" => "green", "b" => "yellow", "blue", "red"]
            );
            expect($res["a"])->to->equal("green");
        });
    });

    describe(":difference", function() {

        it("returns diffs for sequential arrays", function() {
            $res = Arrays::difference([1, 2, 3, 4, 5], [5, 2, 10]);
            expect(implode(",", $res))->to->equal("1,3,4");
        });

        it("returns diffs for key-value arrays", function() {
            $res = Arrays::difference(
                    ["a" => "green", "b" => "brown", "c" => "blue", "red"], ["a" => "green", "yellow", "red"]
            );
            expect($res["b"])->to->equal("brown");
            expect($res["c"])->to->equal("blue");
            expect($res[0])->to->equal("red");
        });
    });

    describe("::zip", function() {

        it("merges togather and evenly values of passed in arrays", function() {
            $res = Arrays::zip(
                    ["moe", "larry", "curly"], [30, 40, 50], [true, false, false]
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


    describe('::object', function() {

        it("converts key-value array to plain object", function() {
            $obj = Arrays::object(["foo" =>
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

    describe("::initial", function() {

        it("removes the last element", function() {
            $res = Arrays::initial([5, 4, 3, 2, 1]);
            expect($res)->to->equal([5, 4, 3, 2]);
        });

        it("removes N elements", function() {
            $res = Arrays::initial([5, 4, 3, 2, 1], 3);
            expect($res)->to->equal([5, 4]);
        });
    });

    describe("::rest", function() {

        it("removes the first element", function() {
            $res = Arrays::rest([5, 4, 3, 2, 1]);
            expect($res)->to->equal([4, 3, 2, 1]);
        });

        it("removes N elements", function() {
            $res = Arrays::rest([5, 4, 3, 2, 1], 3);
            expect($res)->to->equal([2, 1]);
        });
    });

    describe("::compact", function() {

        it("removes falsy elements", function() {
            $res = Arrays::compact([0, 1, false, 2, '', 3]);
            expect($res)->to->equal([1, 2, 3]);
        });

    });

    describe("::flatten", function() {

        it("flattens without shallow constraint", function() {
            $res = Arrays::flatten([1, [2], [3, [[4]]]]);
            expect($res)->to->equal([1, 2, 3, 4]);
        });

        it("flattens with shallow constraint", function() {
            $res = Arrays::flatten([1, [2], [3, [[4]]]], true);
            expect($res)->to->equal([1, 2, 3, [[4]]]);
        });

    });

    describe("::flattening", function() {

        it("implement case #1", function() {
            $method = reflectStaticMethod(Arrays::class, "flattening");
            $res = $method([1, 2, 3], true, false, 4);
            expect($res)->to->equal([]);
        });

        it("implement case #2", function() {
            $method = reflectStaticMethod(Arrays::class, "flattening");
            $res = $method([1, [2], 3], true, true);
            expect($res[0])->to->equal(2);
        });


    });

    describe("::without", function() {

        it("removes specified values", function() {
            $res = Arrays::without([1, 2, 1, 0, 3, 1, 4], 0, 1);
            expect($res)->to->equal([2, 3, 4]);
        });

    });

    describe("::union", function() {

        it("computes the union", function() {
            $res = Arrays::union([1, 2, 3], [101, 2, 1, 10], [2, 1]);
            expect($res)->to->equal([1, 2, 3, 101, 10]);
        });

    });

    describe("::sortedIndex", function() {

        it("operates in case #1", function() {
            $res = Arrays::sortedIndex([10, 20, 30, 40, 50], 35);
            expect($res)->to->equal(3);
        });

        it("operates in case #2", function() {
            $res = Arrays::sortedIndex($this->fixtureStooges, ["name" => "larry", "age" => 50], "age");
            expect($res)->to->equal(1);
        });

    });

     describe("::range", function() {

        it("operates in case #1", function() {
            $res = Arrays::range(10);
            expect($res)->to->equal([0, 1, 2, 3, 4, 5, 6, 7, 8, 9]);
        });

        it("operates in case #2", function() {
            $res = Arrays::range(1, 11);
            expect($res)->to->equal([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);
        });

        it("operates in case #3", function() {
            $res = Arrays::range(0, 30, 5);
            expect($res)->to->equal([0, 5, 10, 15, 20, 25]);
        });

        it("operates in case #4", function() {
            $res = Arrays::range(0, -10, -1);
            expect($res)->to->equal([0, -1, -2, -3, -4, -5, -6, -7, -8, -9]);
        });

    });

     describe("::findLastIndex", function() {

        it("operates in case #1", function() {
            $src = [
                [
                    'id' => 1,
                    'name' => 'Bob',
                    'last' => 'Brown',
                ],
                [
                    'id' => 2,
                    'name' => 'Ted',
                    'last' => 'White',
                ],
                [
                    'id' => 3,
                    'name' => 'Frank',
                    'last' => 'James',
                ],
                [
                    'id' => 4,
                    'name' => 'Ted',
                    'last' => 'Jones',
                ],
            ];

            $res = Arrays::findLastIndex($src, [ "name" => "Ted" ]);
            expect($res)->to->equal(3);
        });

    });

});

