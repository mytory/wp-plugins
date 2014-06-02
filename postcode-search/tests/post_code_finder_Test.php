<?php
    include 'postcode-finder.class.php';

    class Postcode_finder_Test extends PHPUnit_Framework_TestCase {
        public function test_iteration () {
            $finder = new Postcode_finder(fopen('tests/sample-csv','r'), 'land', 0, 0);
            $matches = array('wonderland', 'netherland', 'neverland');
            foreach ($finder as $row) {
                $this->assertEquals(array_shift($matches), $row[0]);
            }
        }
    }