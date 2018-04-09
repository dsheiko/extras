<?php
use Dsheiko\Extras\Chain;

use Dsheiko\Extras\{Collections, Numbers, Strings, Arrays, Booleans, Functions};

class MapObjectFixture
{
    public $foo = "FOO";
    public $bar = "BAR";
}

describe("\\Dsheiko\\Extras\\Chain", function() {

    describe('->__call', function() {

        it("forwards value to a passing Extras class depending on value", function() {
                // collection
            $res = Chain::chain(new \ArrayObject([1,2,3]))
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
            $res = Chain::chain(new MapObjectFixture)
                ->keys()
                ->value();
            expect($res)->to->equal(["foo", "bar"]);
        });

        it("throws when unknown type", function() {
            expect(function(){
                Chain::chain(\NAN)->nonExistingMethod();
            })->to->throw(\InvalidArgumentException::class, "Do not have methods on given type");
        });

        it("throws when mehtod not found", function() {
            expect(function(){
                Chain::chain("string")->nonExistingMethod();
                })->to->throw(
                    \RuntimeException::class,
                    "'Dsheiko\\Extras\\Strings' does not contain method 'nonExistingMethod'"
                );
        });

    });

    describe('->then', function() {

        it("transforms chain value", function() {
            $res = Chain::chain(new \ArrayObject([1,2,3]))
                ->toArray()
                ->then("json_encode")
                ->value();
            expect($res)->to->equal("[1,2,3]");
        });

    });

    describe('->tap', function() {

        it("transforms chain value", function() {
            $res = Chain::chain(new \ArrayObject([1,2,3]))
                ->toArray()
                ->tap("json_encode")
                ->value();
            expect($res)->to->equal("[1,2,3]");
        });

    });

    describe('->guessSet', function() {

        it("guesses Collection", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(new \ArrayObject([1,2,3]));
            expect($res)->to->equal(Collections::class);
        });

        it("guesses String", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method("string");
            expect($res)->to->equal(Strings::class);
        });

        it("guesses Arrays", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method([1,2,3]);
            expect($res)->to->equal(Arrays::class);
        });

        it("guesses Number", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(123);
            expect($res)->to->equal(Numbers::class);
        });

        it("guesses Number from double", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(123.5);
            expect($res)->to->equal(Numbers::class);
        });


        it("guesses Function", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(function(){});
            expect($res)->to->equal(Functions::class);
        });

        it("guesses Boolean", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(true);
            expect($res)->to->equal(Booleans::class);
        });

        it("guesses Boolean (false)", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(false);
            expect($res)->to->equal(Booleans::class);
        });

        it("guesses Other", function() {
            $method = reflectStaticMethod(Chain::class, "guessSet");
            $res = $method(\NAN);
            expect($res)->to->equal("");
        });

    });


});

