<?php
use Dsheiko\Extras\Strings;

describe("\\Dsheiko\\Extras\\Strings", function() {

    describe('::substr', function() {

        it("extracts substring from given position", function() {
            $res = Strings::substr("12345", 1);
            expect($res)->to->equal("2345");
        });

        it("extracts substring from given position and of given length", function() {
            $res = Strings::substr("12345", 1, 3);
            expect($res)->to->equal("234");
        });

    });

    describe('::trim', function() {

        it("strips string of whitespaces", function() {
            $res = Strings::trim("  12345   ");
            expect($res)->to->equal("12345");
        });

        it("strips string of given character", function() {
            $res = Strings::trim("...12345....", ".");
            expect($res)->to->equal("12345");
        });

    });

    describe('::replace', function() {

        it("modifies string by following a given PCRE", function() {
            $res = Strings::replace("12345", "/\d/s", "*");
            expect($res)->to->equal("*****");
        });

    });

    describe('::endsWith', function() {

        it("confirms string ends with given substring", function() {
            $res = Strings::endsWith("12345", "45");
            expect($res)->to->be->ok;
        });

        it("denies string ends with given substring", function() {
            $res = Strings::endsWith("12345", "12");
            expect($res)->not->to->be->ok;
        });

    });

    describe('::startsWith', function() {

        it("confirms string starts with given substring", function() {
            $res = Strings::startsWith("12345", "12");
            expect($res)->to->be->ok;
        });

        it("denies string starts with given substring", function() {
            $res = Strings::startsWith("12345", "45");
            expect($res)->not->to->be->ok;
        });

    });

    describe('::includes', function() {

        it("confirms string includes given substring", function() {
            $res = Strings::includes("12345", "23");
            expect($res)->to->be->ok;
        });

        it("denies string includes given substring", function() {
            $res = Strings::includes("12345", "89");
            expect($res)->not->to->be->ok;
        });

    });

    describe('::includes', function() {

        it("removes substring from string", function() {
            $res = Strings::remove("12345", "23");
            expect($res)->to->equal("145");
        });

        it("does not change string when no match found", function() {
            $res = Strings::remove("12345", "89");
            expect($res)->to->equal("12345");
        });

    });

    describe('::chain', function() {

        it("chains different methods", function() {
           $res = Strings::chain( " 12345 " )
            ->replace("/1/", "5")
            ->replace("/2/", "5")
            ->trim()
            ->substr(1, 3)
            ->value();
            expect($res)->to->equal("534");
        });

        it("throws exception when invalid type given", function() {
            expect(function() {
                Strings::chain([1,2]);
            })->to->throw(\InvalidArgumentException::class, "Target must be a string; 'array' type given");
        });

    });


});

