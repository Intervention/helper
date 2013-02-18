# Intervention Helper Class

Easier handling and formating of strings and dates. Made to work with Laravel 4 but runs also standalone.

## Installation

You can install the Helper classes quick and easy with Composer.

Require the package via Composer in your `composer.json`.

    "intervention/helper": "dev-master"

Run Composer to update the new requirement.

    $ composer update

The Helper classes are built to work with the Laravel 4 Framework. The integration is done in seconds.

Open your Laravel config file `config/app.php` and add the following lines.

In the `$providers` array add the service providers for this package.
    
    'providers' => array(

        ...

        'Intervention\Helper\DateServiceProvider',
        'Intervention\Helper\StringServiceProvider'

    ),
    

Add the facade of this package to the `$aliases` array.

    'aliases' => array(

        ...

        'Date' => 'Intervention\Helper\Facades\Date',
        'String' => 'Intervention\Helper\Facades\String'

    ),

## Usage

### Date Helper

* Date::__construct - Returns new Date Helper object
* Date::format - Formats given timestamp to a readable format (available formats are 'date', 'datetime', 'digitdate', 'iso')
* Date::age - Calculates age between timestamps and returns readable format

### Code Example (Laravel)

```php
// returns '24. Oktober 2003, 10:45' in german locale
return Date::format('2003-10-24 10:45:13', 'datetime');

// returns 'October 24, 2003, 10:45 AM' in english locale
return Date::format('2003-10-24 10:45:13', 'datetime');

// returns '10 Jahre' in german locale
return Date::age('2003-10-24 10:00', '2013-10-24 10:45:13');

// methods also takes unix timestamps of DateTime objects, second parameter is optional
return Date::age(1292177455);
```


### String Helper

* String::__construct - Returns new String Helper object
* String::pluralize - Returns singular or plural based on the given count
* String::alternator - Returns given parameters by turns
* String::formatMoney - Format amount of money based on locale
* String::random - Returns random string in wanted format
* String::shorten - Shortens text to length and keeps integrity of words
* String::slug - Format given string to url-friendly format

### Code Example (Laravel)

```php
// returns '4 cars'
return String::pluralize(4, 'car', 'cars');

// returns '1.200,00 EUR' in german locale
return String::formatMoney(1200, 'EUR');

// echoes different values repeated one after another
for ($i=0; $i < 10; $i++) { 
    echo String::alternator('one', 'two', 'three');
}

// you may also use arrays as input for alternator
for ($i=0; $i < 10; $i++) { 
    echo String::alternator(array('one', 'two', 'three'));
}

```
