<?php
use Dsheiko\Extras\Any;

describe("\\Dsheiko\\Extras\\Any", function() {

    describe('->chain', function() {

        it("forwards value to a passing Extras class depending on value", function() {
                // collection
            $res = Any::chain(new \ArrayObject([1,2,3]))
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

});

