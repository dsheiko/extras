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

});

