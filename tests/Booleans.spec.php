<?php
use Dsheiko\Extras\Booleans;

describe("\\Dsheiko\\Extras\\Booleans", function() {

    describe('::isBoolean', function() {

        it("returns true when BOOL", function() {
            $res = Booleans::isBoolean(true);
            expect($res)->to->be->ok;
        });

        it("returns false when STRING", function() {
            $res = Booleans::isBoolean("1.1");
            expect($res)->not->to->be->ok;
        });

    });

});

