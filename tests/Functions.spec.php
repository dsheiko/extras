<?php
use Dsheiko\Extras\Functions;

function fixtureCounter()
{
    static $count = 0;
    return ++$count;
}

describe("\\Dsheiko\\Extras\\Functions", function() {

    describe('::once', function() {

        it("creates function that executes only once", function() {
            $func = Functions::once("fixtureCounter");
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
        });

    });

    describe('::before', function() {

        it("creates function that executes only 3 times", function() {
            $func = Functions::before("fixtureCounter", 3);
            expect($func())->to->equal(1);
            expect($func())->to->equal(2);
            expect($func())->to->equal(3);
            expect($func())->to->equal(3);
        });

    });

    describe('::after', function() {

        it("creates function that will only be run after being called 3 times", function() {
            $func = Functions::after("fixtureCounter", 3);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(1);
        });

    });

    describe('::throttle', function() {

        it("creates throttled version of function, when called repeatedly invokes origin once in 20 ms", function() {
            $func = Functions::throttle("fixtureCounter", 20);
            expect($func())->to->equal(1);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            usleep(20000);
            expect($func())->to->equal(2);
        });

    });


    describe('::negate', function() {

        it("returns a new negated version of the predicate function", function() {
            $func = Functions::negate(function(){ return false; });
            expect($func())->to->equal(true);
        });

    });



});

