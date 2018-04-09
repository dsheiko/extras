<?php
use Dsheiko\Extras\Utils;
use Dsheiko\Extras\Arrays;
use Dsheiko\Extras\Strings;

describe("\\Dsheiko\\Extras\\Utils (Underscore\Utils)", function() {

    beforeEach(function() {
        $this->fixtureStooges = [
            ["name" => "moe", "age" => 40],
            ["name" => "larry", "age" => 50],
            ["name" => "curly", "age" => 60],
        ];
    });


    describe("::result", function() {

        it("returns result of a scalar", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Utils::result($options, "foo");
            expect($res)->to->equal("FOO");
        });

        it("returns result of a callable", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Utils::result($options, "bar");
            expect($res)->to->equal("BAR");
        });

        it("throws when property does not exist", function() {
            expect(function() {
                Utils::result([], "foo");
            })->to->throw(\InvalidArgumentException::class);
        });
    });


    describe("::resultOf", function() {

        it("returns value when value supplied", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Utils::resultOf($options["foo"]);
            expect($res)->to->equal("FOO");
        });

        it("returns produced value when function supplied", function() {
            $options = [
                "foo" => "FOO",
                "bar" => function() {
                    return "BAR";
                },
            ];
            $res = Utils::resultOf($options["bar"]);
            expect($res)->to->equal("BAR");
        });

    });

    describe('->noop', function() {

        it("returns null", function(){
            $res = Utils::noop(1,2,3);
            expect($res)->to->equal(null);
        });

    });

    describe('->identity', function() {

        it("returns function that bypass the argument", function(){
            $res = Utils::identity();
            expect($res(42))->to->equal(42);
        });

    });

    describe('->constant', function() {

        it("returns the value as was given as argument", function(){
            $res = Utils::constant(42);
            expect($res(1,2,3))->to->equal(42);
        });

    });

    describe('->random', function() {

        it("returns random value (max not suplied)", function(){
            $res = Utils::random(100);
            expect($res >= 0)->to->be->ok;
            expect($res <= 100)->to->be->ok;
        });

        it("returns random value (max suplied)", function(){
            $res = Utils::random(0, 100);
            expect($res >= 0)->to->be->ok;
            expect($res <= 100)->to->be->ok;
        });

    });

    describe('->iteratee', function() {

        it("returns identity for null", function(){
            $res = Utils::iteratee(null);
            expect($res(1))->to->equal(1);
        });

        it("returns macther for array", function(){
            $macther = Utils::iteratee(["foo" => "FOO"]);
            $res = Arrays::find([["foo" => "FOO"]], $macther);
            expect($res["foo"])->to->equal("FOO");
        });

        it("returns function for callable", function(){
            $res = Utils::iteratee(function(){ return 42; });
            expect($res())->to->equal(42);
        });

        it("returns function for callable and binds to supplied context", function(){
            $obj = (object)["value" => 42];
            $res = Utils::iteratee(function(){ return $this->value; }, $obj);
            expect($res())->to->equal(42);
        });

        it("returns property otherwise", function(){
            $res = Utils::iteratee("foo");
            expect($res(["foo" => "FOO"]))->to->equal("FOO");
        });

    });


    describe('->uniqueId', function() {

        it("returns a string", function(){
            $res = Utils::uniqueId();
            expect(\is_string($res))->to->be->ok;
        });

        it("returns string begining from prefix", function(){
            $pref = "contact_";
            $res = Utils::uniqueId($pref);
            expect(Strings::startsWith($res, $pref))->to->be->ok;
        });

    });

    describe('->now', function() {

        it("returns a positive number", function(){
            $res = Utils::now();
            expect($res >0)->to->be->ok;
        });

    });


});

