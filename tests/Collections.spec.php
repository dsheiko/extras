<?php
use Dsheiko\Extras\Collections;

function makeGenearatorCollection(): iterable
{
    foreach (range(1, 3) as $i) {
        yield $i;
    }
}

describe("\\Dsheiko\\Extras\\Collections", function() {

    describe('::each', function() {

        it("iterates over iterable (from generator)", function() {
            $sum = 0;
            Collections::each(makeGenearatorCollection(), function ($i) use (&$sum){
                $sum += $i;
            });
            expect($sum)->to->equal(6);
        });

        it("iterates over ArrayObject", function() {
            $sum = 0;
            Collections::each(new \ArrayObject([1,2,3]), function ($i) use (&$sum){
                $sum += $i;
            });
            expect($sum)->to->equal(6);
        });

        it("iterates over Iterator", function() {
            $sum = 0;
            $obj = new \ArrayObject([1,2,3]);
            Collections::each($obj->getIterator(), function ($i) use (&$sum){
                $sum += $i;
            });
            expect($sum)->to->equal(6);
        });

        it("extracts array", function() {
            $res = Collections::toArray(new \ArrayObject([1,2,3]));
            expect($res)->to->be->an("array");
        });

    });

    describe('::chain', function() {

        it("chains different methods", function() {
           $res = Collections::chain(new \ArrayObject([1,2,3]))
            ->toArray()
            ->value();
            expect($res)->to->equal([1,2,3]);
        });

        it("throws exception when invalid type given", function() {
            expect(function() {
                Collections::chain("string");
            })->to->throw(
                \InvalidArgumentException::class,
                "Target must be a Collection (ArrayObject|ArrayIterator|Traversable); 'string' type given"
            );
        });

    });


});

