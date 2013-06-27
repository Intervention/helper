<?php

namespace Intervention\Helper;

use \DateTime;
use Illuminate\Translation\Translator;

class Date
{
    /**
     * Translator instance
     *
     * @var Translator
     */
    protected $translator;

    /**
     * Create a new instance of the date helper
     *
     * @param Translator $translator
     */
    public function __construct(Translator $translator = null)
    {
        $this->translator = $translator;
    }

    /**
     * Format translation key - checks for package- and app-translations
     *
     * @param  string $key
     * @return string
     */
    private function getTranslationKey($key = null)
    {
        $t = $this->translator;
        $key = $t->has('helper::'.$key) ? 'helper::'.$key : $key;
        return $key;
    }

    /**
     * Format a timestamp based on translation
     *
     * @param  mixed $timestamp    accepts string, unix timestamp and DateTime object
     * @param  string $format
     * @return string
     */
    public function format($format = 'date', $timestamp = null)
    {
        $timestamp = is_numeric($timestamp) ? '@'.intval($timestamp) : $timestamp;
        $timestamp = is_a($timestamp, 'DateTime') ? $timestamp : new DateTime($timestamp);

        $key = $this->getTranslationKey("date.formats.{$format}");
        $format = $this->translator->has($key) ? $this->translator->get($key) : null;

        if (is_null($format)) {
            throw new \InvalidArgumentException('Date format is invalid or does not exists in current language');
        }

        return strftime($format, $timestamp->format('U'));
    }

    /**
     * Calculate age for given timestamp(s)
     *
     * @param  mixed $timestamp1  accepts string, unix-timestamp and DateTime object
     * @param  mixed $timestamp2  accepts string, unix-timestamp and DateTime object
     * @param  string $unit       constraint output to a given unit
     * @return string
     */
    public function age($timestamp1, $timestamp2 = null, $unit = null)
    {
        $timestamp1 = is_numeric($timestamp1) ? '@'.intval($timestamp1) : $timestamp1;
        $timestamp1 = is_a($timestamp1, 'DateTime') ? $timestamp1 : new DateTime($timestamp1);
        $timestamp2 = is_numeric($timestamp2) ? '@'.intval($timestamp2) : $timestamp2;
        $timestamp2 = is_a($timestamp2, 'DateTime') ? $timestamp2 : new DateTime($timestamp2);

        if ($timestamp1 == $timestamp2) {
            return $this->translator->get($this->getTranslationKey('date.n0w'));
        }

        $diff = $timestamp1->diff($timestamp2);

        $total = array(
            'year' => $diff->y,
            'month' => $diff->m + $diff->y * 12,
            'week' => floor($diff->days / 7),
            'day' => $diff->days,
            'hour' => $diff->h + $diff->days * 24,
            'minute' => $diff->h + $diff->i + $diff->days * 24 * 60,
            'second' => $diff->h + $diff->i + $diff->s + $diff->days * 24 * 60 * 60
        );

        if (is_null($unit)) {
            foreach ($total as $key => $value) {
                if ($value > 0) {
                    $lang_key = 'date.' . $key . '_choice';
                    $lang_key = $this->getTranslationKey($lang_key);
                    $unit = $this->translator->choice($lang_key, $value);
                    return $value.' '.$unit;
                }
            }
        } elseif (array_key_exists($unit, $total)) {
            $value = $total[$unit];
            $lang_key = 'date.' . $unit . '_choice';
            $lang_key = $this->getTranslationKey($lang_key);
            $unit = $this->translator->choice($lang_key, $value);
            return $value.' '.$unit;
        }

        throw new \InvalidArgumentException('Invalid argument in function call');
    }
}
