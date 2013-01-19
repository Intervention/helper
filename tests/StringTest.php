<?php

use Intervention\Helper\String;

class StringTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->stringHelper = new String;
    }

    public function testPluralizeSingular()
    {
        $singular = $this->stringHelper->pluralize(1, 'car', 'cars');
        $this->assertEquals($singular, 'car');
    }

    public function testPluralizePlural()
    {
        $plural = $this->stringHelper->pluralize(2, 'car', 'cars');
        $this->assertEquals($plural, 'cars');
    }

    public function testAlternatorArray()
    {
        $data = array('one', 'two', 'three');
        $this->assertEquals($this->stringHelper->alternator($data), 'one');
        $this->assertEquals($this->stringHelper->alternator($data), 'two');
        $this->assertEquals($this->stringHelper->alternator($data), 'three');
    }

    public function testAlternatorParams()
    {
        $this->assertEquals($this->stringHelper->alternator('one', 'two', 'three'), 'one');
        $this->assertEquals($this->stringHelper->alternator('one', 'two', 'three'), 'two');
        $this->assertEquals($this->stringHelper->alternator('one', 'two', 'three'), 'three');
    }

    public function testAlternatorNull()
    {
        $this->assertNull($this->stringHelper->alternator());
    }
}