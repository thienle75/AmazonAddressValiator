<?php

namespace Address\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Events\Dispatcher;
use Illuminate\Config\Repository;
use Address\Helpers\AddressHelper;
use Address\Helpers\CivicAddressHelper;
use Address\Helpers\POBOXAddressHelper;
use Address\Helpers\RuralAddressHelper;
use Address\Observers\AddressObserver;

class Address extends Model{

    protected $table = "addresses";

    protected $fillable = [
        'type',
        'name',
        'street_number',
        'street_name',
        'street_type',
        'street_direction',
        'city',
        'postal_code',
        'province',
        'country',
        'suite',
        'buzzer',
        'pobox',
        'rural_route',
        'station'
    ];

    public $errors = [];

    protected $attributes = [
        'type'=>'',
        'name'=>'',
        'street_number'=>'',
        'street_name'=>'',
        'street_type'=>'',
        'street_direction'=>'',
        'city'=>'',
        'postal_code'=>'',
        'province'=>'',
        'country'=>'',
        'suite'=>'',
        'buzzer'=>'',
        'pobox'=>'',
        'rural_route'=>'',
        'station'=>''
    ];

    /**
     * A getter function for the errors
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * This function adds values to the address line
     * @param $value
     * @param $string
     * @param bool $numericCheck
     * @param string $prefix
     * @param string $suffix
     * @param bool $addSpace
     */
    private function addValue($value, &$string, $numericCheck=false, $prefix='', $suffix='', $addSpace=true)
    {
        if(!empty($value) && $value != ''){
            if($numericCheck) {
                if (ctype_digit($value)) {
                    $string .= $prefix . $value . $suffix;
                } else {
                    if($addSpace) {
                        $string .= ' '.$value ;
                    }else{
                        $string .= $value;
                    }
                }
            }else{
                if($addSpace) {
                    $string .= ' '.$value;
                }else{
                    $string .= $value;
                }
            }
        }
    }

    /**
     * The boot method sets up the Observer for the address model
     */
    public static function boot()
    {
        parent::boot();
        Address::setEventDispatcher(new Dispatcher());
        Address::observe(new AddressObserver);
    }

    /**
     * This function uses the specified parse to parse the street address into its parts
     * @param $address
     * @param $configDir
     */
    public function setAddress($address, $configDir = '')
    {
        $configDir = !empty($configDir) ? $configDir : __DIR__.'/../../config';
        $configArray = require $configDir.'/config.php';

        $config = new Repository();

        foreach($configArray as $key=>$value){
            $config->set('config.'.$key, $value);
        }

        // replacing a number of uneeded characters
        $address  = str_replace(',', '', $address);
        $address  = str_replace('#', '', $address);

        switch($config->get('config.parser')){
            case "default":
                $this->parseAddressDefault($address);
                break;
            case "google":
                //TODO: Coming Soon ...
                break;
        }
    }

    /**
     * This function uses the default parser to parse the address into its parts
     * @param $address
     */
    public function parseAddressDefault($address)
    {
        $addressType = AddressHelper::getAddressType($address);

        $this->type = $addressType;

        switch($addressType){
            case 'pobox':
                //parse the PO BOX
                POBOXAddressHelper::getPOBOX($address, $this);
                //parse the Station
                POBOXAddressHelper::getStation($address, $this);
                break;
            case 'rural':
                //parse the Rural Route
                RuralAddressHelper::getRuralRoute($address, $this);
                //parse the Station
                RuralAddressHelper::getStation($address, $this);
                break;
            case 'pobox_civic':
                //TODO: add pobox parsing
            case 'rural_civic':
                //TODO: add rural parsing
            case 'civic':
                //parse the street type
                //CivicAddressHelper::getStreetType($address, $this);
                //parse the street direction
                //CivicAddressHelper::getStreetDirection($address, $this);
                //parse the unit number
                CivicAddressHelper::getSuiteNumber($address, $this);
                //parse the street number
                CivicAddressHelper::getStreetNumber($address, $this);
                //parse the street name
                CivicAddressHelper::getStreetName($address, $this);
                break;
        }
    }

    public function getFullAddress()
    {
        $address = '';

        switch($this->type){
            case 'civic':
            case 'pobox_civic':
            case 'rural_civic':
                $this->addValue($this->street_number, $address, false, '', '', false);
                $this->addValue($this->street_name, $address);
                $this->addValue($this->street_type, $address);
                $this->addValue($this->street_direction, $address);
                $this->addValue($this->suite, $address, true, ' Unit ', '');
                $this->addValue($this->buzzer, $address, true, ' Buzzer ', '');
                break;
            case 'pobox':
                $this->addValue($this->pobox, $address, true, 'PO BOX ', '', false);
                $this->addValue($this->station, $address, true, ' STN ', '');
                break;
            case 'rural':
                $this->addValue($this->rural_route, $address, true, 'RR ', '', false);
                $this->addValue($this->station, $address, true, ' STN ', '');
                break;
        }

        $this->addValue($this->city, $address);
        $this->addValue($this->province, $address);
        $this->addValue($this->postal_code, $address);
        $this->addValue($this->country, $address);

        return $address;
    }


    /**
     * This function combines the corresponding fields into the address line 1 for the specific type of address
     * @return string
     */
    public function getAddressLine1()
    {
        $addressLine1 = '';

        switch($this->type){
            case 'civic':
            case 'pobox_civic':
            case 'rural_civic':
                $this->addValue($this->street_number, $addressLine1, false, '', '', false);
                $this->addValue($this->street_name, $addressLine1);
                $this->addValue($this->street_type, $addressLine1);
                $this->addValue($this->street_direction, $addressLine1);
                break;
            case 'pobox':
                $this->addValue($this->pobox, $addressLine1, true, 'PO BOX ', '', false);
                $this->addValue($this->station, $addressLine1, true, ' STN ', '');
                break;
            case 'rural':
                $this->addValue($this->rural_route, $addressLine1, true, 'RR ', '', false);
                $this->addValue($this->station, $addressLine1, true, ' STN ', '');
                break;
        }

        return $addressLine1;
    }

    /**
     * This function combines the corresponding fields into the address line 2 for the specific type of address
     * @return string
     */
    public function getAddressLine2()
    {
        $addressLine2 = '';

        switch($this->type){
            case 'civic':
            case 'pobox':
            case 'rural':
            case 'pobox_civic':
            case 'rural_civic':
                $this->addValue($this->suite, $addressLine2, true, 'Unit ', '', false);
                $this->addValue($this->buzzer, $addressLine2, true, ' Buzzer ', '', false);
                break;
        }

        return $addressLine2;
    }
}