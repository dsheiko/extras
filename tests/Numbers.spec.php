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

});

