<?php
use Dsheiko\Extras\Arrays;

describe("\\Dsheiko\\Extras\\Arrays (Underscore\Utils)", function() {

    beforeEach(function() {
        $this->fixtureStooges = [
            ["name" => "moe", "age" => 40],
            ["name" => "larry", "age" => 50],
            ["name" => "curly", "age" => 60],
        ];
    });


    describe("::result", function() {

        it("returns result of a scalar", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Arrays::result($options, "foo");
            expect($res)->to->equal("FOO");
        });

        it("returns result of a callable", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Arrays::result($options, "bar");
            expect($res)->to->equal("BAR");
        });

        it("throws when property does not exist", function() {
            expect(function() {
                Arrays::result([], "foo");
            })->to->throw(\InvalidArgumentException::class);
        });
    });
});

