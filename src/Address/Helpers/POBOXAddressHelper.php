<?php

namespace Address\Helpers;

class POBOXAddressHelper extends AddressHelper
{
    /**
     * This function does a lookup on the POBOXkeys array and returns the indx or sets the pobox
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @param boolean $returnIndx
     * @return int
     */
    public static function getPOBOX($address, &$addressModel, $returnIndx=false)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $indx = AddressHelper::findInArray(AddressHelper::$POBOXkeys, $tokenizedAddress, true);

        if($indx!=='' && $indx!==null) {
            if ($returnIndx) {
                return $indx;
            } else {
                $nextIndxExists = array_key_exists($indx + 1, $tokenizedAddress);
                if($nextIndxExists) {
                    $currentIndxIsAlpha = ctype_alpha(str_replace('.','',$tokenizedAddress[$indx]));
                    //check the second index and append it
                    if(ctype_digit($tokenizedAddress[$indx + 1]) && $currentIndxIsAlpha){
                        $addressModel->pobox = $tokenizedAddress[$indx] . ' ' . $tokenizedAddress[$indx + 1];
                    } elseif(!ctype_digit($tokenizedAddress[$indx + 1]) && strtolower($tokenizedAddress[$indx + 1])=='box') {
                        //check the third index and append it.
                        $nextNextIndxExists = array_key_exists($indx + 2, $tokenizedAddress);
                        if($nextNextIndxExists) {
                            $addressModel->pobox = $tokenizedAddress[$indx] . ' ' . $tokenizedAddress[$indx + 1] . ' ' . $tokenizedAddress[$indx + 2];
                        }
                    } else {
                        $addressModel->pobox = $tokenizedAddress[$indx];
                    }
                }
            }
        }else{
            return $indx;
        }
    }

    /**
     * This function does a lookup on the stationKeys array and returns the station indx or sets the station
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @param boolean $returnIndx
     * @return int | string
     */
    public static function getStation($address, &$addressModel, $returnIndx = false)
    {
        return AddressHelper::getTwoPartField(
            $address,
            $addressModel,
            'station',
            AddressHelper::$stationKeys,
            $returnIndx
        );
    }
}