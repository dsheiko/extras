<?php
use Dsheiko\Extras\Arrays;


describe("\\Dsheiko\\Extras\\Arrays", function() {


    describe('::isAssocArray', function() {

        it("returns true for pure associative array", function() {
            $res = Arrays::isAssocArray([ "foo" => 1, "bar" => 1, ]);
            expect($res)->to->be->ok;
        });

        it("returns true for mixed associative/sequential array", function() {
            $res = Arrays::isAssocArray([ "foo" => 1, "bar" => 1, 2, 3 ]);
            expect($res)->to->be->ok;
        });

        it("returns true for pure sequential array", function() {
            $res = Arrays::isAssocArray([ 1, 2, ]);
            expect($res)->not->to->be->ok;
        });

    });

    describe('::replace', function() {

        it("replaces the element matching the predicate function", function() {
           $array = Arrays::replace([
                ["val" => "FOO"],
                ["val" => "BAR"],
            ], function ($item){
                return $item["val"] === "BAR";
            }, ["val" => "BAZ"]);
            expect($array[1]["val"])->to->equal("BAZ");
        });

        it("appends the element to the array if none matching the predicate function found", function() {
           $array = Arrays::replace([
                ["val" => "FOO"],
                ["val" => "BAR"],
            ], function ($item){
                return $item["val"] === "BAZ";
            }, ["val" => "BAZ"]);
            expect($array[2]["val"])->to->equal("BAZ");
        });

    });

    describe('::chain', function() {

        it("chains different methods", function() {
           $res = Arrays::chain([1,2,3])
            ->map(function($num){ return $num + 1; })
            ->map(function($num){ return $num + 1; })
            ->value();
            expect(implode(",", $res))->to->equal("3,4,5");
        });

        it("throws exception when invalid type given", function() {
            expect(function() {
                Arrays::chain("string");
            })->to->throw(\InvalidArgumentException::class, "Target must be an array; 'string' type given");
        });

    });


});

