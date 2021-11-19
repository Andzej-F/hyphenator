<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{

    function testAddSymbol()
    {
        require './App/hyphhenation.php';

        $this->assertEquals('m*i*s*t*r*a*n*s*l*a*t*e', addSymbol('mistranslate', '*'));
        $this->assertEquals('.m*i*s1t*r*a*n*s*l*a*t*e.', addSymbol('.m*i*s1t*r*a*n*s*l*a*t*e.', '*'));
        $this->assertEquals('a2n', addSymbol('a2n', '*'));
        $this->assertEquals('.m*i*s1', addSymbol('.mis1', '*'));
        $this->assertEquals('m2i*s', addSymbol('m2is', '*'));
        $this->assertEquals('2n1s2', addSymbol('2n1s2', '*'));
        $this->assertEquals('n2s*l', addSymbol('n2sl', '*'));
        $this->assertEquals('s1l2', addSymbol('s1l2', '*'));
        $this->assertEquals('s3l*a*t', addSymbol('s3lat', '*'));
        $this->assertEquals('s*t4r', addSymbol('st4r', '*'));
        $this->assertEquals('4t*e.', addSymbol('4te.', '*'));
        $this->assertEquals('1t*r*a', addSymbol('1tra', '*'));
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
        $this->assertEquals([6 => 1], numberPosition('.m*i*s1'));
    }

    // public function testHyphenate()
    // {
    //     require 'matches.txt';
    //     $array = file('https://gist.githubusercontent.com/cosmologicon/1e7291714094d71a0e25678316141586/raw/006f7e9093dc7ad72b12ff9f1da649822e56d39d/tex-hyphenation-patterns.txt', FILE_IGNORE_NEW_LINES);

    //     // $this->assertEquals('mis-trans-late', hyphenate('mistranslate', $array));
    //     // $this->assertEquals('vig-or-ous', hyphenate('vigorous', [0 => '.mis1']));
    // }


    // public function testHyphenate()
    // {
    //     $this->assertEquals('.m*i*s1t*r*a*n*s*l*a*t*e', hyphenate('.mistranslate', [0 => ".mis1"]));
    // }
}
