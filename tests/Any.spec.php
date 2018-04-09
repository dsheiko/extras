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

    describe('->isDate', function() {

        it("returns true when DateTime object", function(){
            $res = Any::isDate(new DateTime('2011-01-01T15:03:01.012345Z'));
            expect($res)->to->be->ok;
        });

    });

    describe('->isError', function() {

        it("returns true when an Error", function(){
            try {
                throw new Error("message");
            } catch (\Error $ex) {
                $res = Any::isError($ex);
                expect($res)->to->be->ok;
            }
        });

    });

    describe('->isException', function() {

        it("returns true when an Exception", function(){
            try {
                throw new Exception("message");
            } catch (\Exception $ex) {
                $res = Any::isException($ex);
                expect($res)->to->be->ok;
            }
        });

    });

    describe('->isNull', function() {

        it("returns true when NULL", function(){
            $res = Any::isNull(null);
            expect($res)->to->be->ok;
        });

        it("returns false when INT", function(){
            $res = Any::isNull(10);
            expect($res)->not->to->be->ok;
        });

    });



});

