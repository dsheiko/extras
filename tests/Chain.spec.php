<?php
use Dsheiko\Extras\Collections;

describe("\\Dsheiko\\Extras\\Lib\\Chain", function() {

    describe('->__call', function() {

        it("forwards value to a passing Extras class depending on value", function() {
                // collection
            $res = Collections::chain(new \ArrayObject([1,2,3]))
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
            $res = Collections::chain(new \ArrayObject([1,2,3]))
                ->toArray()
                ->middleware("json_encode")
                ->value();
            expect($res)->to->equal("[1,2,3]");
        });

    });


});

