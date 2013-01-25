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

    public function testMoneyFormat()
    {
        $this->stringHelper->locale = 'de';
        $this->assertEquals($this->stringHelper->moneyFormat(10), '10,00 €');
        $this->assertEquals($this->stringHelper->moneyFormat(6000), '6.000,00 €');
        $this->assertEquals($this->stringHelper->moneyFormat(149431.45), '149.431,45 €');
        $this->assertEquals($this->stringHelper->moneyFormat(9.99), '9,99 €');
        $this->assertEquals($this->stringHelper->moneyFormat(9.99, null), '9,99');

        $this->stringHelper->locale = 'en';
        $this->assertEquals($this->stringHelper->moneyFormat(9.99, 'EUR'), 'EUR 9.99');
        $this->assertEquals($this->stringHelper->moneyFormat(9.99, 'USD'), 'USD 9.99');
        $this->assertEquals($this->stringHelper->moneyFormat(149431.45), '€ 149,431.45');
        $this->assertEquals($this->stringHelper->moneyFormat(9000.10, 'USD'), 'USD 9,000.10');
        $this->assertEquals($this->stringHelper->moneyFormat(241.90, false), '241.90');
    }
}