<?php
/**
 * Created by PhpStorm.
 * User: Mitko
 * Date: 4/9/2015
 * Time: 1:18 PM
 */

//namespace Address;

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(__DIR__.'/vendor/autoload.php');

new Address\Helpers\EloquentHelper();
/*
echo '<div class="row"><div class="col-lg-3" style="margin: auto 0px;">';
echo Helpers\FormHelper::renderRuralAddressForm('/test/action/post', null);
echo '</div></div>';
*/



$fakes = [
    /*
    '123-456 Fake Street West',
    '123 - 456 Fake Street West',
    '456 Fake Street West Unit 123',
    '456 Fake ST W Apt 123',
    '36A Main St.',
    'POBOX 1234 STN A',
    'p.o. box 43 STN 3',
    'PO 234 STN 23',
    'RR 2 Station 3',
    '2 Sheppard East',
    '1245 Dupont St',
    'Unit 100 - 5973 Vedder Road',
    '#860-2945 Jacklin Road',
    'Apt. 123 096 Amparo Ranch',
    '6550 BOUL. JEAN TALON EST, SUITE 101',
    '730 Montee des Pionniers',
    '3855 Boul Le Carrefour',
    '265A Boul St Jean',
    '1980-C Como Lake Avenue',
    '#120, 6655 178th St Nw',
    '4610 Ontario Street, Unit C, RR3',
    '#120, 6655 178th St Nw',
    '18Yk Centre 4802 - 50Th Ave',
    '149-2401G Millstream Rd.',
    '30 45th Street South',
    '2325-111 Street NW',
    '16703 127TH ST. NW',
    '145-8100 No. 2 Rd',
    '2121 E Trans Canada Hwy',
    '2411 160th Street, Unit 40',
    'Unit 200 505 Main St. S.',*/
    '3433 North Rd. Unit 105',
    '10 East Point Way',
    '123-456 Fake Street West',
];

foreach($fakes as $fake){
    var_dump($fake);
    $address = new Address\Models\Address();
    $address->setAddress($fake);
    //var_dump($address->suite);
    var_dump($address->getAttributes());
    var_dump($address->getAddressLine1().' '.$address->getAddressLine2());
}

/*
$faker = \Faker\Factory::create();

for($i = 0; $i <1; $i++){
    $fakeAddrs = $faker->streetAddress;
    echo $fakeAddrs.PHP_EOL;
    $fakeAddrs = 'Apt.123 096 Amparo Ranch';
    $address = new Models\Address();
    $address->setAddress($fakeAddrs);
    var_dump($address->getAttributes());
}
*/