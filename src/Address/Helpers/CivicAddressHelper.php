<?php

namespace Address\Helpers;

class CivicAddressHelper extends AddressHelper
{
    /**
     * This function does a lookup on the streetTypes array and returns the type
     * @param string $address
     * @param \Address\Models\Address $addressModel
     */
    public static function getStreetType($address, &$addressModel)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $addressModel->street_type =  AddressHelper::findInArray(AddressHelper::$streetTypes, $tokenizedAddress);
    }

    /**
     * This function does a lookup on the streetDirections array and returns the direction full name
     * @param string $address
     * @param \Address\Models\Address $addressModel
     */
    public static function getStreetDirection($address, &$addressModel)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $addressModel->street_direction = AddressHelper::findInArray(AddressHelper::$streetDirections, $tokenizedAddress);
    }

    /**
     * This function does a lookup on the unitAbbreviations array and returns the next item in the tokenized address
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @param boolean $returnIndx
     * @return int | string
     */
    public static function getSuiteNumber($address, &$addressModel, $returnIndx = false)
    {
        return AddressHelper::getTwoPartField(
            $address,
            $addressModel,
            'suite',
            AddressHelper::$unitAbbreviations,
            $returnIndx
        );
    }

    /**
     * This function eliminates the other elements from the address and returns the street number
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @return string
     */
    public static function getStreetNumber($address, &$addressModel)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $ignoredIndexes = CivicAddressHelper::eliminateIndexes($address, $addressModel);

        foreach($ignoredIndexes as $index){
            unset($tokenizedAddress[$index]);
        }

        $remainingTokens = array_values($tokenizedAddress);

        // accommodate for 123-12 Main St.
        if(count($remainingTokens)>=3){
            $candidateStreetNumber = $remainingTokens[2];
            if($remainingTokens[1]=='-') {
                $addressModel->suite = $remainingTokens[0];
                $addressModel->street_number = $candidateStreetNumber;
            }elseif(strpos($remainingTokens[0],'-')!==false) {
                $splitNumbers = explode('-', $remainingTokens[0]);
                $addressModel->suite = $splitNumbers[0];
                $addressModel->street_number = $splitNumbers[1];
            }elseif(ctype_digit($remainingTokens[0]) && ctype_digit($remainingTokens[1])){
                $addressModel->suite = $remainingTokens[0];
                $addressModel->street_number = $remainingTokens[1];
            }elseif($remainingTokens[0]=='-'){
                $addressModel->street_number = $remainingTokens[1];
            }elseif(ctype_digit($remainingTokens[0]) || ctype_alnum($remainingTokens[0]) && !ctype_alpha($remainingTokens[0])){
                $addressModel->street_number = $remainingTokens[0];
            }elseif(preg_match('/\d-[a-zA-z]*/', $remainingTokens[0])){
                $addressModel->street_number = $remainingTokens[0];
            }
        }else{
            $candidateStreetNumber = $remainingTokens[0];

            // accommodate for 123-12 Main St.
            if(strpos($candidateStreetNumber,'-')!==false) {
                $splitNumbers = explode('-', $candidateStreetNumber);
                $addressModel->suite = $splitNumbers[0];
                $addressModel->street_number = $splitNumbers[1];
            }elseif(preg_match('/\d/', $candidateStreetNumber)){
                $addressModel->street_number = $candidateStreetNumber;
            }else{
                $addressModel->street_number = '';
            }
        }
    }

    /**
     * This function eliminates the other elements from the address and returns the street name
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @return string
     */
    public static function getStreetName($address, &$addressModel)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $ignoredIndexes = CivicAddressHelper::eliminateIndexes($address, $addressModel);

        if($addressModel->street_number!='') {
            $streetNumberIndx = array_search($addressModel->street_number, $tokenizedAddress);
            $suiteStreetNumberIndx = array_search($addressModel->suite.'-'.$addressModel->street_number, $tokenizedAddress);

            if($streetNumberIndx!==false) {
                $ignoredIndexes[] = $streetNumberIndx;
            } elseif($suiteStreetNumberIndx!==false) {
                $ignoredIndexes[] = $suiteStreetNumberIndx;
            }
        }

        foreach($ignoredIndexes as $index){
            unset($tokenizedAddress[$index]);
        }

        $remainingTokens = array_values($tokenizedAddress);

        if(count($remainingTokens)==0){
            // accommodate for North Rd type of addresses
            $addressModel->street_name = $addressModel->street_direction;
            $addressModel->street_direction = '';
        }elseif(count($remainingTokens)>1){
            // accommodate for 123-45 Main St.
            if((count($remainingTokens)>2 && $remainingTokens[1]=='-') || (count($remainingTokens)>2 && ctype_digit($remainingTokens[0]) && ctype_digit($remainingTokens[1]))){
                unset($remainingTokens[0]);
                unset($remainingTokens[1]);
            }elseif(count($remainingTokens)==2 && $remainingTokens[0]=='-'){
                unset($remainingTokens[0]);
            }elseif(ctype_digit($remainingTokens[0]) || ctype_alnum($remainingTokens[0]) && !ctype_alpha($remainingTokens[0])){
                unset($remainingTokens[0]);
            }elseif(preg_match('/\d-[a-zA-z]*/', $remainingTokens[0])){
                $addressModel->street_number = $remainingTokens[0];
            }
            $addressModel->street_name = implode(' ',$remainingTokens);
        }else{
            $addressModel->street_name = $remainingTokens[0];
        }
    }

    /**
     * This function finds the
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @return array
     */
    public static function eliminateIndexes($address, $addressModel)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $ignoredIndexes = [];

        if($addressModel->street_type!='') {
            $indx = array_search($addressModel->street_type, $tokenizedAddress);
            if($indx!==false){
                $ignoredIndexes[] = $indx;
            }
        }

        if($addressModel->street_direction!='') {
            $indx = array_search($addressModel->street_direction, $tokenizedAddress);
            if($indx!==false){
                $ignoredIndexes[] = $indx;
            }
        }

        $suiteNumberIndx = CivicAddressHelper::getSuiteNumber($address, $addressModel, true);

        if($suiteNumberIndx!=='' && $suiteNumberIndx!==null) {
            $ignoredIndexes[] = $suiteNumberIndx;

            if (ctype_alpha(str_replace('.','',$tokenizedAddress[$suiteNumberIndx]))) {
                $ignoredIndexes[] = $suiteNumberIndx + 1;
            }
        }


        return $ignoredIndexes;
    }
}