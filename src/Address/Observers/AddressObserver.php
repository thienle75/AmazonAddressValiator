<?php
/**
 * Created by PhpStorm.
 * User: Mitko
 * Date: 4/9/2015
 * Time: 2:25 PM
 */

namespace Address\Observers;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Illuminate\Validation\Validator;

class AddressObserver
{
    private $validator;
    private $rules = [
        'type' => 'Required',
        'name' => '',
        'street_number' => '',
        'street_number_suffix' => '',
        'street_name' => '',
        'street_type' => '',
        'street_direction' => '',
        'city' => 'Required',
        'postal_code' => 'Required',
        'province' => 'Required|min:2|max:2|alpha',
        'country' => 'Required|min:2|max:2|alpha',
        'suite' => '',
        'buzzer' => '',
        'pobox' => '',
        'rural_route' => '',
        'station' => ''
    ];

    /**
     * The constructor sets up the translator and error messages for the validator
     * @param array $data
     */
    public function __construct($data = [])
    {
        $translator = new Translator('en');
        $translator->addLoader('array', new ArrayLoader);

        $validation = ['validation' => include(__DIR__ . '/../../lang/en/validation.php')];
        $translator->addResource('array', $validation, 'en');

        $this->validator = new Validator($translator, $data, $this->rules);
    }

    /**
     * This function sets up the rules for postal_code based on the country
     * @param $country
     */
    public function setRulesBasedOnCountry($country)
    {
        switch($country){
            case 'CA':
                $this->rules['postal_code'] = "Required|regex:/[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]/";
                break;
            case 'US':
                $this->rules['postal_code'] = ["Required","regex:/((([0-9]{5})-([0-9]{4}))|([0-9]{5}))/"];
                break;
        }
    }


    public function setRulesBasedOnType($type)
    {
        switch($type){
            case 'civic':
                $this->rules['street_number'] = "Required";
                $this->rules['street_name'] = "Required";
                break;
            case 'pobox':
                $this->rules['pobox'] = "Required";
                $this->rules['station'] = "Required";
                break;
            case 'pobox_civic':
                $this->rules['street_number'] = "Required";
                $this->rules['street_name'] = "Required";
                $this->rules['street_type'] = "Required";
                $this->rules['pobox'] = "Required";
                $this->rules['station'] = "Required";
                break;
            case 'rural':
                $this->rules['rural_route'] = "Required";
                $this->rules['station'] = "Required";
                break;
            case 'rural_civic':
                $this->rules['street_number'] = "Required";
                $this->rules['street_name'] = "Required";
                $this->rules['street_type'] = "Required";
                $this->rules['rural_route'] = "Required";
                $this->rules['station'] = "Required";
                break;
        }
    }

    public function saving(Model $model)
    {
        $data = $model->attributesToArray();

        //Set the appropriate validation rules
        $this->setRulesBasedOnType($model->type);
        $this->setRulesBasedOnCountry($model->country);

        $this->validator->setData($data);
        $this->validator->setRules($this->rules);

        if($this->validator->fails()){
            $model->errors = $this->validator->errors();
            return false;
        } else {
            return true;
        }
    }

    public function creating(Model $model){}
    public function created(Model $model){}
    public function updating(Model $model){}
    public function updated(Model $model){}
    public function deleting(Model $model){}
    public function deleted(Model $model){}
    public function saved(Model $model){}
}