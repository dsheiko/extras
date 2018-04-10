<?php
use Dsheiko\Extras\Type\PlainObject;

describe("\\Dsheiko\\Extras\\Type\\PlainObject", function() {


    describe('->__get', function() {

        it("returns value when found", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            expect($po->foo)->to->equal("FOO");
        });

        it("returns null when not found", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            expect($po->quiz)->to->equal(null);
        });

    });

    describe('->__isset', function() {

        it("checks if key exists", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            expect(isset($po->foo))->to->equal(true);
        });

    });

    describe('->toArray', function() {

        it("return source array", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            $res = $po->toArray();
            expect($res)->to->be->an("array");
        });

    });

    describe('->keys', function() {

        it("return properties", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            $res = $po->keys();
            expect($res)->to->equal(["foo", "bar"]);
        });

    });

    describe('->values', function() {

        it("return values", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            $res = $po->values();
            expect($res)->to->equal(["FOO", "BAR"]);
        });

    });

    describe('->entries', function() {

        it("return pairs", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            $res = $po->entries();
            expect($res[0])->to->equal(["foo", "FOO"]);
            expect($res[1])->to->equal(["bar", "BAR"]);
        });

    });


    describe('->assign', function() {

        it("merges objects", function() {
            $po1 = new PlainObject(["foo" => "FOO"]);
            $po2 = new PlainObject(["bar" => "BAR"]);
            $res = PlainObject::assign($po1, $po2);
            expect($res->foo)->to->equal("FOO");
            expect($res->bar)->to->equal("BAR");
        });

    });

    describe('->pairs', function() {

        it("return pairs", function() {
            $po = new PlainObject(["foo" => "FOO", "bar" => "BAR"]);
            $res = $po->pairs();
            expect($res[0])->to->equal(["foo", "FOO"]);
            expect($res[1])->to->equal(["bar", "BAR"]);
        });

    });


    describe("::mapObject", function() {

        it("returns transformed object", function() {
            $po = new PlainObject([
                    "start" => 5,
                    "end" => 12,
            ]);
            $res = $po->mapObject(function($val){
                return $val + 5;
            });
            expect($res->start)->to->equal(10);
            expect($res->end)->to->equal(17);
        });
    });

    describe("::invert", function() {

        it("swaps keys and values", function() {
            $po = new PlainObject([
                "Moe" => "Moses",
                "Larry" => "Louis",
                "Curly" => "Jerome",
            ]);
            $res = $po->invert();
            expect($res->Moses)->to->equal("Moe");
            expect($res->Louis)->to->equal("Larry");
            expect($res->Jerome)->to->equal("Curly");

        });
    });

    describe("::findKey", function() {

        it("finds key", function() {
            $po = new PlainObject([
                "foo" => [
                    'name' => 'Ted',
                    'last' => 'White',
                ],
                "bar" => [
                    'name' => 'Frank',
                    'last' => 'James',
                ],
                "baz" => [
                    'name' => 'Ted',
                    'last' => 'Jones',
                ],
            ]);
            $res = $po->findKey([ "name" => "Ted" ]);
            expect($res)->to->equal("foo");
        });

    });

    describe("::pick", function() {

        it("filters array by key list", function() {
            $po = new PlainObject([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
            ]);

            $res = $po->pick('name', 'age');
            expect(isset($res->name))->to->be->ok;
            expect(isset($res->age))->to->be->ok;
            expect(isset($res->userid))->not->to->be->ok;
        });

    });

     describe("::omit", function() {

        it("filters array by key list", function() {
            $po = new PlainObject([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
            ]);

            $res = $po->omit('name', 'age');
            expect(isset($res->name))->not->to->be->ok;
            expect(isset($res->age))->not->to->be->ok;
            expect(isset($res->userid))->to->be->ok;
        });

    });

    describe("::defaults", function() {

        it("returns extended array", function() {
            $po = new PlainObject([
                "flavor" => "chocolate"
            ]);
            $res = $po->defaults([
                "flavor" => "vanilla",
                "sprinkles" => "lots",
            ]);
            expect($res->flavor)->to->equal("chocolate");
            expect($res->sprinkles)->to->equal("lots");
        });
    });

    describe("::has", function() {

        it("looks for key", function() {
            $res = new PlainObject([
                'name' => 'moe',
                'age' => 50,
                'userid' => 'moe1',
            ]);
            expect($res->has("name"))->to->be->ok;
            expect($res->has("age"))->to->be->ok;
            expect($res->has("nonexisting"))->not->to->be->ok;
        });

    });

    describe("::isEmpty", function() {

        it("checks empty object", function() {
            $res = new PlainObject([]);
            expect($res->isEmpty())->to->be->ok;
        });

        it("checks not empty object", function() {
            $res = new PlainObject(["foo" => "FOO"]);
            expect($res->isEmpty())->not->to->be->ok;
        });

    });



});

