<?php
use Dsheiko\Extras\Chain;

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

