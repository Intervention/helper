<?php 

namespace Intervention\Helper;

class String
{
    public $locale;

    public function __construct($locale = null) 
    {
        $this->locale = $locale;
    }

    static public function pluralize($count = 1, $singular, $plural)
    {
        return ($count > 1) ? $plural : $singular;
    }

    static public function alternator()
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

    public function moneyFormat($amount, $currency = '€')
    {
        switch ($this->locale) {
            case 'de':
                $amount = number_format($amount, 2, ',', '.');
                $format = is_string($currency) ? $amount.' '.$currency : $amount;
                break;
            
            default:
            case 'en':
                $amount = number_format($amount, 2, '.', ',');
                $format = is_string($currency) ? $currency.' '.$amount : $amount;
                break;
        }
        
        return $format;
    }

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

    public function shorten($str, $length = 100, $end = '&hellip;')
    {
        if (strlen($str) > $length) {
            $str = substr(trim($str), 0, $length);
            $str = substr($str, 0, strlen($str) - strpos(strrev($str), ' '));
            $str = $str.$end;
        }
        return $str;
    }

    public function ellipsize($str, $max_length, $position = 1, $ellipsis = '&hellip;')
    {
        // Strip tags
        $str = trim(strip_tags($str));

        // Is the string long enough to ellipsize?
        if (strlen($str) <= $max_length)
        {
            return $str;
        }

        $beg = substr($str, 0, floor($max_length * $position));

        $position = ($position > 1) ? 1 : $position;

        if ($position === 1)
        {
            $end = substr($str, 0, -($max_length - strlen($beg)));
        }
        else
        {
            $end = substr($str, -($max_length - strlen($beg)));
        }

        return $beg.$ellipsis.$end;
    }

    public function slug($str, $limiter = '_')
    {
        $str = mb_strtolower($str, 'utf-8');
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
