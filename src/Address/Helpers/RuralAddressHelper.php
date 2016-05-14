<?php

namespace Address\Helpers;

class RuralAddressHelper extends AddressHelper
{
    /**
     * This function does a lookup on the ruralKeys array and returns the rural_route indx or sets the rural_route
     * @param string $address
     * @param \Address\Models\Address $addressModel
     * @param boolean $returnIndx
     * @return int
     */
    public static function getRuralRoute($address, &$addressModel, $returnIndx=false)
    {
        return AddressHelper::getTwoPartField(
            $address,
            $addressModel,
            'rural_route',
            AddressHelper::$ruralKeys,
            $returnIndx
        );
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