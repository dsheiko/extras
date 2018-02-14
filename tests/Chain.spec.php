<?php
use Dsheiko\Extras\Chain;

class MapObjectFixture
{
    public $foo = "FOO";
    public $bar = "BAR";
}

describe("\\Dsheiko\\Extras\\Chain", function() {

    describe('->__call', function() {

        it("forwards value to a passing Extras class depending on value", function() {
                // collection
            $res = Chain::from(new \ArrayObject([1,2,3]))
                ->toArray()
                // array
                ->map(function($num){ return [ "num" => $num ]; })
                ->reduce(function($carry, $arr){
                    $carry .= $arr["num"];
                    return $carry;

                }, "")
                // string
                ->replace("/2/", "")
                ->value();
            expect($res)->to->equal("13");
        });

        it("converts object into key-value array", function() {
            $res = Chain::from(new MapObjectFixture)
                ->keys()
                ->value();
            expect($res)->to->equal(["foo", "bar"]);
        });
    });

    describe('->middleware', function() {

        it("transforms chain value", function() {
            $res = Chain::from(new \ArrayObject([1,2,3]))
                ->toArray()
                ->middleware("json_encode")
                ->value();
            expect($res)->to->equal("[1,2,3]");
        });

    });


});

