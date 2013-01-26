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

    public function testShorten()
    {
        $str = 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.';
        $this->assertEquals($this->stringHelper->shorten($str), 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut &hellip;');
        $this->assertEquals($this->stringHelper->shorten($str, 25), 'Lorem ipsum dolor sit &hellip;');
        $this->assertEquals($this->stringHelper->shorten($str, 10), 'Lorem &hellip;');
        $this->assertEquals($this->stringHelper->shorten($str, 10, '...'), 'Lorem ...');
    }

    public function testRandom()
    {
        $random1 = $this->stringHelper->random(32);
        $random2 = $this->stringHelper->random(32);
        $random3 = $this->stringHelper->random(10);

        $random_alpha = $this->stringHelper->random(24, 'alpha');
        $random_alnum = $this->stringHelper->random(24, 'alnum');
        $random_num = $this->stringHelper->random(24, 'num');
        $random_md5 = $this->stringHelper->random(100, 'md5');

        $this->assertEquals(strlen($random1), 32);
        $this->assertEquals(strlen($random2), 32);
        $this->assertEquals(strlen($random3), 10);
        $this->assertEquals(strlen($random_md5), 32);
        $this->assertFalse($random1 == $random2);

        $this->assertTrue((bool) preg_match('/^[a-zA-Z]{24}$/', $random_alpha));
        $this->assertTrue((bool) preg_match('/^[a-zA-Z0-9]{24}$/', $random_alnum));
        $this->assertTrue((bool) preg_match('/^[0-9]{24}$/', $random_num));
    }

    public function testSlug()
    {
        $this->assertEquals($this->stringHelper->slug('My First Blog Post'), 'my_first_blog_post');
        $this->assertEquals($this->stringHelper->slug('My First Blog Post', '-'), 'my-first-blog-post');
        $this->assertEquals($this->stringHelper->slug('My First Blog Post', 'test'), 'my_first_blog_post');
        $this->assertEquals($this->stringHelper->slug('Das ist ein Ä und das ist ein ß!'), 'das_ist_ein_ae_und_das_ist_ein_ss');
    }
}