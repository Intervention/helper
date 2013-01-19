<?php 

namespace Intervention\Helper;

class String
{
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
}
