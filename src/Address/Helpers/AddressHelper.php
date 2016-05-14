<?php

namespace Address\Helpers;

class AddressHelper
{
    public static $streetDirections = [
        "East","E", "North","N", "Northeast","NE", "Northwest","NW", "South","S", "Southeast","SE", "Southwest","SW",
        "West","W", "Est","E", "Nord","N", "Nord-Est","NE", "Nord-Ouest","NO", "Sud","S","Sud-Est","SE", "Sud-Ouest",
        "SO", "Ouest","O"
    ];

    public static $unitAbbreviations = [
        "APARTMENT", "APT", "APT.",
        "SUITE", "UNIT",
        "APPARTEMENT", "APP", "APP.",
        "BUREAU", "UNITÉ",
        "LOCAL", "LOCALE"
    ];

    public static $streetTypes = [
        "Abbey","ABBEY","Acres","ACRES","Allée","ALLÉE","Alley","ALLEY","Autoroute","AUT","Avenue","AVE","AV","Bay",
        "BAY","BEACH","Bend","BEND","Boulevard","BLVD","BOUL","By-pass","BYPASS","Byway","BYWAY","CAMPUS","Cape","CAPE",
        "Carré","CAR","Carrefour","CARREF","Centre","CTR","Cercle","CERCLE","Chase","CHASE","Chemin","CH","Circle",
        "CIR","Circuit","CIRCT","Close","CLOSE","Common","COMMON","Concession","CONC","Corners","CRNRS","Côte","CÔTE",
        "Cour","COUR","Cours","COURS","Court","CRT","Cove","COVE","Crescent","CRES","Croissant","CROIS","Crossing",
        "CROSS","Cul-de-sac","CDS","Dale","DALE","Dell","DELL","Diversion","DIVERS","Downs","DOWNS","Drive","DR",
        "Échangeur","ÉCH","End","END","Esplanade","ESPL","Estates","ESTATE","Expressway","EXPY","Extension","EXTEN",
        "Farm","FARM","Field","FIELD","Forest","FOREST","Freeway","FWY","Front","FRONT","Gardens","GDNS","GATE","Glade",
        "GLADE","Glen","GLEN","Green","GREEN","Grounds","GRNDS","Grove","GROVE","Harbour","HARBR","Heath","HEATH",
        "Heights","HTS","Highlands","HGHLDS","Highway","HWY","HILL","HOLLOW","Île","ÎLE","Impasse","IMP","INLET",
        "ISLAND","KEY","KNOLL","LANDNG","LANE","Limits","LMTS","LINE","LINK","Lookout","LKOUT","LOOP","MALL","MANOR",
        "MAZE","MEADOW","MEWS","MONTÉE","MOOR","MOUNT","Mountain","MTN","Orchard","ORCH","PARADE","PARC","Park","PK",
        "Parkway","PKY","Passage","PASS","PATH","Pathway","PTWAY","PINES","Place","PL","PLACE","Plateau","PLAT","PLAZA",
        "Point","PT","POINTE","PORT","Private","PVT","Promenade","PROM","QUAI","QUAY","RAMP","RANG","Range","RG",
        "RIDGE","RISE","Road","RD","Rond-point","RDPT","Route","RTE","ROW","RUE","Ruelle","RLE","RUN","Sentier","SENT",
        "Square","SQ","Street","ST","Subdivision","SUBDIV","Terrace","TERR","Terrasse","TSSE","Thicket","THICK",
        "TOWERS","Townline","TLINE","TRAIL","Turnabout","TRNABT","VALE","VIA","VIEW","VILLGE","VILLAS","VISTA","VOIE",
        "WALK","WAY","WHARF","WOOD","WYND"
    ];

    public static $POBOXkeys = [
        'POBOX','PO','P.O.'
    ];

    public static $stationKeys = [
        'STATION','STN','STN.'
    ];

    public static $ruralKeys = [
        'RR','R.R.'
    ];

    /**
     * This function finds items within the tokenizedAddress array
     * @param array $items
     * @param array $tokenizedAddress
     * @param bool $returnIndx
     * @return mixed|string
     */
    public static function findInArray($items, $tokenizedAddress, $returnIndx=false)
    {
        $name = '';

        foreach($items as $fullName) {
            if (in_array($fullName, $tokenizedAddress)) {
                $name = $fullName;
                break;
            } elseif (in_array(strtolower($fullName), $tokenizedAddress)) {
                $name = strtolower($fullName);
                break;
            } elseif (in_array(strtolower($fullName).'.', $tokenizedAddress)) {
                $name = strtolower($fullName).'.';
                break;
            } elseif (in_array(strtoupper($fullName), $tokenizedAddress)) {
                $name = strtoupper($fullName);
                break;
            } elseif (in_array(strtoupper($fullName).'.', $tokenizedAddress)) {
                $name = strtoupper($fullName).'.';
                break;
            } elseif (in_array(ucfirst(strtolower($fullName)), $tokenizedAddress)) {
                $name = ucfirst(strtolower($fullName));
                break;
            } elseif (in_array(ucfirst(strtolower($fullName)).'.', $tokenizedAddress)) {
                $name = ucfirst(strtolower($fullName)) . '.';
                break;
            } else {
                continue;
            }
        }

        if($name!=='') {
            $indx = array_search($name, $tokenizedAddress);
            if ($returnIndx) {
                return $indx;
            } else {
                return $name;
            }
        } else {
            if ($returnIndx) {
                foreach($tokenizedAddress as $indx=>$token){
                    foreach($items as $fullName) {
                        if ($token == $fullName) {
                            return $indx;
                        } elseif ($token == strtolower($fullName)) {
                            return $indx;
                        } elseif ($token == strtolower($fullName).'.') {
                            return $indx;
                        } elseif ($token == strtoupper($fullName)) {
                            return $indx;
                        } elseif ($token == strtoupper($fullName).'.') {
                            return $indx;
                        } elseif ($token == ucfirst(strtolower($fullName))) {
                            return $indx;
                        } elseif ($token == ucfirst(strtolower($fullName)).'.') {
                            return $indx;
                        } else {
                            continue;
                        }
                    }
                }
            } else {
                return '';
            }
        }
    }

    /**
     * This function loops over the specified
     * @param $address
     * @param $addressModel
     * @param $fieldName
     * @param $keys
     * @param bool $returnIndx
     * @return mixed|string
     */
    public static function getTwoPartField($address, &$addressModel, $fieldName, $keys, $returnIndx=false)
    {
        $address = str_replace(',','',$address);
        $tokenizedAddress = explode(" ",$address);

        $indx = AddressHelper::findInArray($keys, $tokenizedAddress, true);

        if($indx!=='' && $indx!==null) {
            if ($returnIndx) {
                return $indx;
            } else {
                if (array_key_exists($indx + 1, $tokenizedAddress) && ctype_alpha(str_replace('.','',$tokenizedAddress[$indx]))) {

                    $addressModel->$fieldName = $tokenizedAddress[$indx] . ' ' . $tokenizedAddress[$indx + 1];
                } else {
                    $addressModel->$fieldName = $tokenizedAddress[$indx];
                }
            }
        }else{
            return $indx;
        }
    }

    public static function getAddressType($address)
    {
        $type = 'civic';

        $tokenizedAddress = explode(" ",$address);

        //check poboxKeys;
        foreach(AddressHelper::$POBOXkeys as $poBOXKey){
            $lowerCase = strtolower($poBOXKey);
            $CapitalCase = ucwords($lowerCase);

            if(in_array($poBOXKey, $tokenizedAddress)){
                $type = 'pobox';
                break;
            } elseif(in_array($lowerCase, $tokenizedAddress)) {
                $type = 'pobox';
                break;
            } elseif(in_array($CapitalCase, $tokenizedAddress)) {
                $type = 'pobox';
                break;
            }
        }

        //check ruralKeys
        foreach(AddressHelper::$ruralKeys as $ruralKey){
            $lowerCase = strtolower($ruralKey);
            $CapitalCase = ucwords($lowerCase);

            if(in_array($ruralKey, $tokenizedAddress)){
                $type = 'rural';
                break;
            } elseif(in_array($lowerCase, $tokenizedAddress)) {
                $type = 'rural';
                break;
            } elseif(in_array($CapitalCase, $tokenizedAddress)) {
                $type = 'rural';
                break;
            }
        }

        return $type;
    }
}