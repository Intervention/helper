<?php

namespace Intervention\Helper;

use Doctrine\Common\Inflector\Inflector;

class String
{
    /**
     * The locale of the class
     *
     * @var string
     */
    public $locale;

    /**
     * String encoding definition
     *
     * @var string
     */
    public $encoding = 'utf-8';

    /**
     * Create new String Helper instance
     *
     * @param string $locale
     * @param string $encoding
     */
    public function __construct($locale = null, $encoding = 'utf-8')
    {
        $this->locale = $locale;
        $this->encoding = $encoding;
    }

    /**
     * Return singular or plural parameter, based on the given count
     *
     * @param  integer $count
     * @param  string  $singular
     * @param  string  $plural
     * @return string
     */
    public static function pluralize($count = 1, $singular, $plural = null)
    {
        if ($count == 1) {
            return $singular;
        }

        return is_null($plural) ? Inflector::pluralize($singular) : $plural;
    }

    /**
     * Cycles through given parameters
     *
     * @return mixed    Values to cycle through as array or different parameters
     */
    public static function alternator()
    {
        static $i;

        if (func_num_args() == 0) {
            $i = 0;
            return null;
        }
        $args = func_get_args();
        $args = is_array($args[0]) ? $args[0] : $args;
        return $args[($i++ % count($args))];
    }

    /**
     * Format amount of money based on locale
     *
     * @param  float $amount
     * @param  string $currency
     * @return string
     */
    public function formatMoney($amount, $currency = '€', $options = array())
    {
        switch ($this->locale) {
            case 'de':
                $amount = number_format($amount, 2, ',', '.');
                $format = is_string($currency) ? $amount.' '.$currency : $amount;
                break;

            default:
            case 'en':
                $amount = number_format($amount, 2, '.', ',');
                $format = is_string($currency) ? $currency.
                    ((isset($options['space_after_symbol']) && $options['space_after_symbol'])?' ':'').
                    $amount : $amount;
                break;
        }

        return $format;
    }

    /**
     * Legacy method for 'formatMoney'
     * 
     * @param  float    $amount
     * @param  string   $currency
     * @return string
     */
    public function moneyFormat($amount, $currency = '€')
    {
        return $this->formatMoney($amount, $currency);
    }

    /**
     * Format byte filesize to human readable filesize
     *
     * @param  integer $bytes
     * @return string
     */
    public function formatFilesize($bytes)
    {
        $units = array('bytes', 'kb', 'MB', 'GB', 'TB', 'PB');
        $level = floor(log($bytes)/log(1024));

        $output = sprintf('%.2f %s', ($bytes/pow(1024, floor($level))), $units[$level]);

        return $output;
    }

    /**
     * Return random string
     *
     * @param  integer $length
     * @param  string  $type
     * @return string
     */
    public function random($length = 32, $type = 'alnum')
    {
        switch ($type) {

            case 'alpha':
                $pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;

            case 'alnum':
            case 'alphanum':
                $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                break;

            case 'num':
            case 'numeric':
                $pool = '0123456789';
                break;

            case 'md5':
                return md5(uniqid(mt_rand()));
                break;

            default:
                throw new \Exception("Invalid random string type [{$type}].");
        }

        return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
    }

    /**
     * Shortens text to length and keeps integrity of words
     *
     * @param  string  $str
     * @param  integer $length
     * @param  string  $end
     * @return string
     */
    public function shorten($str, $length = 100, $end = '&#8230;')
    {
        if (strlen($str) > $length) {
            $str = substr(trim($str), 0, $length);
            $str = substr($str, 0, strlen($str) - strpos(strrev($str), ' '));
            $str = trim($str.$end);
        }
        return $str;
    }

    /**
     * Format given string to url-friendly format
     *
     * @param  string $str
     * @param  string $limiter
     * @return string
     */
    public function slug($str, $limiter = '_')
    {
        $str = mb_strtolower($str, $this->encoding);
        $limiter = in_array($limiter, array('-', '_')) ? $limiter : '_';

        $search = array(
            0 => '/\s/',
            1 => '/ä/',
            2 => '/ö/',
            3 => '/ü/',
            4 => '/ß/',
            5 => '/[^a-zA-Z0-9_-]/'
        );

        $replace = array(
            0 => $limiter,
            1 => 'ae',
            2 => 'oe',
            3 => 'ue',
            4 => 'ss',
            5 => ''
        );

        return preg_replace($search, $replace, $str);
    }

}
