# PHP Address #
===================


## Requirements

This library uses PHP 5.4+.

## Installation ##

It is recommended that you install the PHP Throttle library [through composer](http://getcomposer.org/). To do so,
add the following lines to your ``composer.json`` file.


```
#!javascript

{
  ...
  "repositories": [
    {
      "type": "package",
      "package": {
        "name": "raw-inc/php-address",
        "version": "5.0.0.1",
        "source": {
          "url": "git@bitbucket.org:raw-inc/php-address",
          "type": "git",
          "reference": "release-5.0"
        },
        "autoload": {
          "psr-4": {
            "Address\\": "src/Address"
          }
        }
      }
    }
  ],
  "require": {
    "raw-inc/php-address": "5.0.0.1"
  },
 ...
}
```

## SETUP: without Laravel ##

First you will need to setup the database structure for the model. You will find a schema file in the schema directory of the package.
Execute it and you should be good to go.

Then you will need to configure the package to use your database. There is a file src/config/config.php which is the default file used.
You can reconfigure the package by copying it to another directory, modifying the values and then feeding the directory to the EloquentHelper.
(e.g. new  Address\Helpers\EloquentHelper('/var/www/mysite/config'); )

Example use without Laravel:

```
#!php

require_once(__DIR__.'/vendor/autoload.php');

// start the Eloquent ORM by instantiating the helper
new  Address\Helpers\EloquentHelper();

$address = new Address\Models\Address();
$address->type = 'civic';
$address->name = 'RAW Inc';
$address->street_number = '1681';
$address->street_name = 'Langstaff';
$address->street_type = 'Rd';
$address->street_direction = '';
$address->city = 'Concord';
$address->postal_code = 'L4K 5T3';
$address->province = 'ON';
$address->country = 'CA';
$address->suite = 'Suite 15';
$address->buzzer = '';
$address->pobox = '';
$address->rural_route = '';
$address->station = '';

$address->save();

```

## SETUP: with Laravel ##

First you will need to setup the database structure for the model. Since you are using Laravel the package comes with a migration file
that you can use to set things up. Simply run the artisan command below.

php artisan migrate --package=raw-inc/php-address

Since you are using the package within Laravel you do not need to configure the db credentials.

Example Use:

```
#!php

$address = new Address\Models\Address();
$address->type = 'civic';
$address->name = 'RAW Inc';
$address->street_number = '1681';
$address->street_name = 'Langstaff';
$address->street_type = 'Rd';
$address->street_direction = '';
$address->city = 'Concord';
$address->postal_code = 'L4K 5T3';
$address->province = 'ON';
$address->country = 'CA';
$address->suite = 'Suite 15';
$address->buzzer = '';
$address->pobox = '';
$address->rural_route = '';
$address->station = '';
$address->save();

```

Furthermore you can extend the Address\Models\Address() model in order to add your relations to the address objects.
NOTE: if you extend the class you will need to add the observer manually to your new class. Observers are not inherited.
In order to do that you will need to add the following method to your model.
```
#!php

    /**
     * The boot method sets up the Observer for the address model
     */
    public static function boot()
    {
        parent::boot();
        Address::observe(new \Address\Observers\AddressObserver());
    }

```

## Version Notes

5.0.0.1 - This version is meant to work with Laravel 5.0 packages.

## Special Features

### Address Parsing
Currently the package has the capability to parse some addresses into all the fields. In the future a service like google's geo decode
will be implemented to allow for more correct parsing.

Example Use:

```
#!php

$address = new Address\Models\Address();
// The setAddress function will attempt to parse out the street type, street number, street name, suite number, pobox, station, rural route
$address->setAddress('1681 Langstaff Rd Suite 15');
$address->name = 'RAW Inc';
$address->city = 'Concord';
$address->postal_code = 'L4K 5T3';
$address->province = 'ON';
$address->country = 'CA';
$address->save();

```

### Address Forms
The package also comes with some prebuilt twitter/bootstrap forms for the address.

Example Use:

```
#!PHP

$formHelper = new Address\Helpers\FormHelper();
$formHelper->renderCivicAddressFullForm('/address/submit');

```