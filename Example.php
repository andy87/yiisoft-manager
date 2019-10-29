<?php

class Example {

    public static function test( $obj )
    {
        echo '<pre>';
        print_r([$obj]);
        exit('</pre>');
    }

}