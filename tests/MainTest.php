<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{

    function testAddAsterisk()
    {
        require 'main.php';

        $this->assertEquals('*m*i*s*t*r*a*n*s*l*a*t*e*', addAsterisk('mistranslate'));
        $this->assertEquals('a2n', addAsterisk('a2n'));
        $this->assertEquals('.m*i*s1', addAsterisk('.mis1'));
        $this->assertEquals('m2i*s', addAsterisk('m2is'));
        $this->assertEquals('2n1s2', addAsterisk('2n1s2'));
        $this->assertEquals('n2s*l', addAsterisk('n2sl'));
        $this->assertEquals('s1l2', addAsterisk('s1l2'));
        $this->assertEquals('s3l*a*t', addAsterisk('s3lat'));
        $this->assertEquals('s*t4r', addAsterisk('st4r'));
        $this->assertEquals('4t*e.', addAsterisk('4te.'));
        $this->assertEquals('1t*r*a', addAsterisk('1tra'));
    }

    public function testNumberPosition()
    {
        $this->assertEquals([], numberPosition('abc'));
        $this->assertEquals([0 => 4, 1 => 8, 2 => 5], numberPosition('485'));

        $this->assertEquals([1 => 2], numberPosition('a2n'));
        $this->assertEquals([4 => 1], numberPosition('.mis1'));
        $this->assertEquals([1 => 2], numberPosition('m2is'));
        $this->assertEquals([0 => 2, 2 => 1, 4 => 2], numberPosition('2n1s2'));
        $this->assertEquals([1 => 1, 3 => 2], numberPosition('s1l2'));
        $this->assertEquals([1 => 3], numberPosition('s3lat'));
        $this->assertEquals([0 => 4], numberPosition('4te.'));
    }

    public function testHyphenate()
    {
        $this->assertEquals('m*i*s1t*r*a*n*s*l*a*t*e', hyphenate('mistranslate', [0 => '.mis1']));
    }

    // $start_array = [0 => ".mis1"];
    // $end_array = [0 => "4te."];
    // $middle_array = [
    //     0 => "a2n",
    //     1 => "m2is",
    //     2 => "2n1s2",
    //     3 => "n2sl",
    //     4 => "s1l2",
    //     5 => "s3lat",
    //     6 => "st4r",
    //     7 => "1tra"
    // ];



    // public function testHyphenate()
    // {
    //     $this->assertEquals('.m*i*s1t*r*a*n*s*l*a*t*e', hyphenate('.mistranslate', [0 => ".mis1"]));
    // }
}
