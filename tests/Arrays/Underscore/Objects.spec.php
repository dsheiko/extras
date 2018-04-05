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
});

