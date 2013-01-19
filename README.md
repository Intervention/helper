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
