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
                Chain::chain(NAN)->nonExistingMethod();
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


});

