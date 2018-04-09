<?php
use Dsheiko\Extras\Numbers;

describe("\\Dsheiko\\Extras\\Numbers", function() {

    describe('::isNumber', function() {

        it("returns true when INT", function() {
            $res = Numbers::isNumber(1);
            expect($res)->to->be->ok;
        });

        it("returns true when DOUBLE", function() {
            $res = Numbers::isNumber(1.1);
            expect($res)->to->be->ok;
        });

        it("returns false when STRING", function() {
            $res = Numbers::isNumber("1.1");
            expect($res)->not->to->be->ok;
        });

    });

    describe('::isInteger', function() {

        it("returns true when INT", function() {
            $res = Numbers::isInteger(1);
            expect($res)->to->be->ok;
        });

        it("returns false when DOUBLE", function() {
            $res = Numbers::isInteger(1.1);
            expect($res)->not->to->be->ok;
        });

        it("returns false when STRING", function() {
            $res = Numbers::isNumber("1.1");
            expect($res)->not->to->be->ok;
        });

    });

    describe('::isNaN', function() {

        it("returns true when NaN", function() {
            $res = Numbers::isNaN(\NAN);
            expect($res)->to->be->ok;
        });

        it("returns false when number", function() {
            $res = Numbers::isNaN(10);
            expect($res)->not->to->be->ok;
        });

    });

    describe('::isFinite', function() {

        it("returns false when INFINITE", function() {
            $res = Numbers::isFinite(\INF);
            expect($res)->not->to->be->ok;
        });

        it("returns false when INFINITE (log(0))", function() {
            $res = Numbers::isFinite(log(0));
            expect($res)->not->to->be->ok;
        });

        it("returns true when INT", function() {
            $res = Numbers::isFinite(10);
            expect($res)->to->be->ok;
        });

    });

    describe('::parseFloat', function() {

        it("returns a number when float", function() {
            $src = "4.567abcdefgh";
            $res = Numbers::isNaN(Numbers::parseFloat($src));
            expect($res)->not->to->be->ok;
        });

        it("returns NaN when a string", function() {
            $src = "abcdefgh";
            $res = Numbers::isNaN(Numbers::parseFloat($src));
            expect($res)->to->be->ok;
        });
    });

     describe('::parseInt', function() {

        it("converts from dec", function() {
            $src = "123";
            $res = Numbers::parseInt($src);
            expect($res)->to->equal(123);
        });

        it("converts from hex", function() {
            $src = "0xF";
            $res = Numbers::parseInt($src, 16);
            expect($res)->to->equal(15);
        });

        it("converts from bin", function() {
            $src = "101110";
            $res = Numbers::parseInt($src, 2);
            expect($res)->to->equal(46);
        });

        it("returns NaN when failed converting", function() {
            $src = "0xF";
            $res = Numbers::parseInt($src, 2);
            expect(Numbers::isNaN($res))->to->be->ok;
        });

    });

     describe('::toFixed', function() {

        it("formats without precision", function() {
            $src = 12345.6789;
            $res = Numbers::toFixed($src);
            expect($res)->to->equal((double)12346);
        });

        it("formats with precision 1", function() {
            $src = 12345.6789;
            $res = Numbers::toFixed($src, 1);
            expect($res)->to->equal(12345.7);
        });

        it("formats with precision 6", function() {
            $src = 12345.6789;
            $res = Numbers::toFixed($src, 6);
            expect($res)->to->equal(12345.678900);
        });

    });

     describe('::toPrecision', function() {

        it("formats without precision", function() {
            $src = 5.123456;
            $res = Numbers::toPrecision($src);
            expect($res)->to->equal(5.123456);
        });

        it("formats with precision 5", function() {
            $src = 5.123456;
            $res = Numbers::toPrecision($src, 5);
            expect($res)->to->equal(5.1235);
        });

        it("formats with precision 2", function() {
            $src = 5.123456;
            $res = Numbers::toPrecision($src, 2);
            expect($res)->to->equal(5.1);
        });

        it("formats with precision 1", function() {
            $src = 5.123456;
            $res = Numbers::toPrecision($src, 1);
            expect($res)->to->equal((float)5);
        });

    });

});

