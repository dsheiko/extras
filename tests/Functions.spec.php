<?php
use Dsheiko\Extras\Functions;

class fixtureCounter
{
    public static $count = 0;

    public static function increment()
    {
         return ++static::$count;
    }

    public static function reset()
    {
        static::$count = 0;
    }

}
describe("\\Dsheiko\\Extras\\Functions", function() {

    beforeEach(function(){
        fixtureCounter::reset();
    });

    describe('::once', function() {

        it("creates function that executes only once", function() {
            $func = Functions::once("fixtureCounter::increment");
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
        });

    });

    describe('::before', function() {

        it("creates function that executes only 3 times", function() {
            $func = Functions::before("fixtureCounter::increment", 3);
            expect($func())->to->equal(1);
            expect($func())->to->equal(2);
            expect($func())->to->equal(3);
            expect($func())->to->equal(3);
        });

    });

    describe('::after', function() {

        it("creates function that will only be run after being called 3 times", function() {
            $func = Functions::after("fixtureCounter::increment", 3);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(1);
        });

    });

    describe('::throttle', function() {

        it("creates throttled version of function, when called repeatedly invokes origin once in 20 ms", function() {
            $func = Functions::throttle("fixtureCounter::increment", 20);
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


     describe('::memoize', function() {

        it("caches results with an array for input", function() {
            $target = [ "a" => 1, "b" => 2 ];
            $counter = Functions::memoize("fixtureCounter::increment");
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
        });

        it("caches results with an object for input", function() {
            $target = new \ArrayObject([ "a" => 1, "b" => 2 ]);
            $counter = Functions::memoize("fixtureCounter::increment");
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
        });

        it("call function for non-cached arguments", function() {
            $counter = Functions::memoize("fixtureCounter::increment");
            expect($counter(1))->to->equal(1);
            expect($counter(2))->to->equal(2);
            expect($counter(3))->to->equal(3);
        });

    });

    describe('::chain', function() {

        it("chains different methods", function() {
           $res = Functions::chain(function(){ return false; })
            ->negate()
            ->value();
            expect($res())->to->equal(true);
        });

        it("throws exception when invalid type given", function() {
            expect(function() {
                Functions::chain([1,2]);
            })->to->throw(
                \InvalidArgumentException::class,
                "Target must be an callable|string|Closure; 'array' type given"
            );
        });

    });



});

