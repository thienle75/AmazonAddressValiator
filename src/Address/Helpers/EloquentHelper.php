<?php
/**
 * Created by PhpStorm.
 * User: Mitko
 * Date: 4/9/2015
 * Time: 1:09 PM
 */

namespace Address\Helpers;

use Illuminate\Config\Repository;
use Illuminate\Database\Capsule\Manager as Capsule;

class EloquentHelper {

    public function __construct($configDir=''){
        $capsule = new Capsule;

        $configDir = !empty($configDir) ? $configDir : __DIR__.'/../../config';
        $configArray = require $configDir.'/config.php';

        $config = new Repository();

        foreach($configArray as $key=>$value){
            $config->set('config.'.$key, $value);
        }

        $capsule->addConnection($config->get('config.connection'));

        // Setup the Eloquent ORM
        $capsule->bootEloquent();
    }
}