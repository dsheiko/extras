<?php
use Dsheiko\Extras\{Functions, Arrays};

class FixtureClass
{
    public static function testStatic(){
        return true;
    }
    public function testDynamic(){
        return true;
    }
}

class FixtureCounter
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
        FixtureCounter::reset();
    });

    describe('::once', function() {

        it("creates function that executes only once", function() {
            $func = Functions::once("FixtureCounter::increment");
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
            expect($func())->to->equal(1);
        });

    });

    describe('::before', function() {

        it("creates function that executes only 3 times", function() {
            $func = Functions::before("FixtureCounter::increment", 3);
            expect($func())->to->equal(1);
            expect($func())->to->equal(2);
            expect($func())->to->equal(3);
            expect($func())->to->equal(3);
        });

    });

    describe('::after', function() {

        it("creates function that will only be run after being called 3 times", function() {
            $func = Functions::after("FixtureCounter::increment", 3);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(1);
        });

    });

    describe('::throttle', function() {

        it("creates throttled version of function, when called repeatedly invokes origin once in 20 ms", function() {
            $func = Functions::throttle("FixtureCounter::increment", 20);
            expect($func())->to->equal(1);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            expect($func())->to->equal(false);
            usleep(20000);
            expect($func())->to->equal(2);
        });

    });

    describe('::bind', function() {

        it("returns callable bound to a new context", function() {
            $obj = Arrays::object(["foo" => "FOO"]);
            $target = function(){ return $this->foo; };
            $res = Functions::bind($target, $obj);
            expect($res())->to->equal("FOO");
        });

    });

    describe('::apply', function() {

        it("calls callable bound to a new context with no args", function() {
            $obj = Arrays::object(["foo" => "FOO"]);
            $target = function(){ return $this->foo; };
            $res = Functions::apply($target, $obj);
            expect($res)->to->equal("FOO");
        });

        it("calls callable bound to a new context with args", function() {
            $obj = Arrays::object(["foo" => "FOO"]);
            $target = function( $input ){ return $input . "_" . $this->foo; };
            $res = Functions::apply($target, $obj, ["BAR"]);
            expect($res)->to->equal("BAR_FOO");
        });

    });

    describe('target', function() {

        it("can be a closure", function() {
            $res = Functions::call(function(){ return true; });
            expect($res)->to->equal(true);
        });

        it("can be a string - is_string", function() {
            $res = Functions::call("is_string", null, "string");
            expect($res)->to->equal(true);
        });

        it("can be a string - FixtureClass::testStatic", function() {
            $res = Functions::call("FixtureClass::testStatic");
            expect($res)->to->equal(true);
        });

        it("can be an array - [FixtureClass , testStatic]", function() {
            $res = Functions::call(["FixtureClass" , "testStatic"]);
            expect($res)->to->equal(true);
        });

        it("can be an array - [\$obj , testDynamic]", function() {
            $obj = new FixtureClass();
            $res = Functions::call([$obj , "testDynamic"]);
            expect($res)->to->equal(true);
        });

    });

    describe('::call', function() {


        it("calls callable bound to a new context with no args", function() {
            $obj = Arrays::object(["foo" => "FOO"]);
            $target = function(){ return $this->foo; };
            $res = Functions::call($target, $obj);
            expect($res)->to->equal("FOO");
        });

        it("calls callable bound to a new context with args", function() {
            $obj = Arrays::object(["foo" => "FOO"]);
            $target = function( $input ){ return $input . $this->foo; };
            $res = Functions::call($target, $obj, "BAR");
            expect($res)->to->equal("BARFOO");
        });

    });

    describe('::toString', function() {

        it("returns function string representation", function() {
            $res = Functions::toString("strlen");
            expect($res)->to->contain("Function ");
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
            $counter = Functions::memoize("FixtureCounter::increment");
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
        });

        it("caches results with an object for input", function() {
            $target = new \ArrayObject([ "a" => 1, "b" => 2 ]);
            $counter = Functions::memoize("FixtureCounter::increment");
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
            expect($counter($target))->to->equal(1);
        });

        it("call function for non-cached arguments", function() {
            $counter = Functions::memoize("FixtureCounter::increment");
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
                "Target must be a callable; 'array' type given"
            );
        });

    });



});

