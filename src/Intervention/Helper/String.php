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
}
