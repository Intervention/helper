<?php

date_default_timezone_set('CET');

use Intervention\Helper\Date;
use Illuminate\Translation\Translator;
use Illuminate\Translation\FileLoader;
use Illuminate\Filesystem\Filesystem;

class DateTest extends PHPUnit_Framework_TestCase
{
    protected $dateHelper;
    protected $translator;

    public function setUp()
    {
        $locale = 'en';
        $fallback = 'en';

        $filesystem = new Filesystem;
        $lang_dir = dirname(__DIR__).'/src/lang';
        $loader = new FileLoader($filesystem, $lang_dir);
        $translator = new Translator($loader, $locale, $fallback);
        $this->translator = $translator;
        $this->dateHelper = new Date($translator);
    }

    public function testLanguageKeysExist()
    {
        $this->assertTrue($this->translator->has('date.n0w'));
        $this->assertTrue($this->translator->has('date.second_choice'));
        $this->assertTrue($this->translator->has('date.minute_choice'));
        $this->assertTrue($this->translator->has('date.hour_choice'));
        $this->assertTrue($this->translator->has('date.day_choice'));
        $this->assertTrue($this->translator->has('date.week_choice'));
        $this->assertTrue($this->translator->has('date.month_choice'));
        $this->assertTrue($this->translator->has('date.year_choice'));
        $this->assertTrue($this->translator->has('date.age'));
    }

    public function testTimestampsEqualNow()
    {
        $answer = $this->translator->get('date.n0w');
        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsSecondExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.second_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:12:13');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsSecondsExact()
    {
        $time = 10;
        $period = $this->translator->choice('date.second_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:12:22');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMinuteExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.minute_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:13:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMinutesExact()
    {
        $time = 10;
        $period = $this->translator->choice('date.minute_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:22:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsHourExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.hour_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 13:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsHoursExact()
    {
        $time = 10;
        $period = $this->translator->choice('date.hour_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 22:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsDayExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.day_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-13 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsDaysExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.day_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-14 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsWeekExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.week_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-19 12:12:12', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsWeeksExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.week_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-10 12:12:12', '2012-12-24 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMonthExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.month_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-11-12 12:12:12', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMonthsExact()
    {
        $time = 3;
        $period = $this->translator->choice('date.month_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-9-12 12:12:12', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsYearExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.year_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2011-12-12 12:12:12', '2012-12-12 12:13:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsYearsExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.year_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2010-12-12 12:12:12', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMinuteNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.minute_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:13:20');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMinutesNotExact()
    {
        $time = 10;
        $period = $this->translator->choice('date.minute_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 12:22:20');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsHourNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.hour_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 13:20:20');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsHoursNotExact()
    {
        $time = 10;
        $period = $this->translator->choice('date.hour_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-12 22:20:20');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsDayNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.day_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-13 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsDaysNotExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.day_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2012-12-14 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsWeekNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.week_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-19 14:14:14', '2012-12-12 12:12:12');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsWeeksNotExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.week_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-10 12:12:12', '2012-12-24 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMonthNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.month_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-11-12 12:12:12', '2012-12-14 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsMonthsNotExact()
    {
        $time = 3;
        $period = $this->translator->choice('date.month_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-9-12 12:12:12', '2012-12-14 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsYearNotExact()
    {
        $time = 1;
        $period = $this->translator->choice('date.year_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2011-11-14 12:12:12', '2012-12-12 14:14:14');
        $this->assertEquals($answer, $age);
    }

    public function testAgeIsYearsNotExact()
    {
        $time = 2;
        $period = $this->translator->choice('date.year_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2010-11-12 12:12:12', '2012-12-14 14:14:14');
        $this->assertEquals($answer, $age);
    }


    public function testAgeIsSecondsWithUnit()
    {
        $time = 34300803;
        $period = $this->translator->choice('date.second_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'second');
        $this->assertEquals('34300803 seconds', $age);
    }

    public function testAgeIsMinutesWithUnit()
    {
        $time = 571682;
        $period = $this->translator->choice('date.minute_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'minute');
        $this->assertEquals('571682 minutes', $age);
    }

    public function testAgeIsHoursWithUnit()
    {
        $time = 9529;
        $period = $this->translator->choice('date.hour_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'hour');
        $this->assertEquals('9529 hours', $age);
    }

    public function testAgeIsDaysWithUnit()
    {
        $time = 397;
        $period = $this->translator->choice('date.day_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'day');
        $this->assertEquals('397 days', $age);
    }

    public function testAgeIsWeeksWithUnit()
    {
        $time = 56;
        $period = $this->translator->choice('date.week_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'week');
        $this->assertEquals('56 weeks', $age);
    }

    public function testAgeIsMonthsWithUnit()
    {
        $time = 13;
        $period = $this->translator->choice('date.month_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'month');
        $this->assertEquals('13 months', $age);
    }

    public function testAgeIsYearsWithUnit()
    {
        $time = 1;
        $period = $this->translator->choice('date.year_choice', $time);
        $answer = $this->translator->get('date.age', array('time' => $time, 'period' => $period));

        $age = $this->dateHelper->age('2012-12-12 12:12:12', '2011-11-11 11:11:11', 'year');
        $this->assertEquals('1 year', $age);
    }

    public function testAgeWithUnixTimestamp()
    {
        $age = $this->dateHelper->age(1292177455, 1292177480);
        $this->assertEquals('25 seconds', $age);

        $age = $this->dateHelper->age(1292177455, 1232175480);
        $this->assertEquals('1 year', $age);
    }

    public function testFormat()
    {
        $timestamp = '2013-01-17 13:41:12';
        $var = $this->dateHelper->format($timestamp, 'digitdate');
        $this->assertEquals('01/17/2013', $var);

        $timestamp = '1292177455';
        $var = $this->dateHelper->format($timestamp, 'digitdate');
        $this->assertEquals('12/12/2010', $var);

        $timestamp = 1292177455;
        $var = $this->dateHelper->format($timestamp, 'digitdate');
        $this->assertEquals('12/12/2010', $var);

        $timestamp = new \DateTime('2010-12-24');
        $var = $this->dateHelper->format($timestamp, 'digitdate');
        $this->assertEquals('12/24/2010', $var);

        $timestamp = new \DateTime('2010-12-24 23:00:00');
        $var = $this->dateHelper->format($timestamp, 'time');
        $this->assertEquals('11:00 PM', $var);
    }

}
