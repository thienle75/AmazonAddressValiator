<?php
/**
 * Created by PhpStorm.
 * User: Thien Le
 * Date: 4/9/2015
 * Time: 1:08 PM
 */

return [
    "connection" => [
        "driver"    => "mysql",
        "host"      => "localhost",
        "database"  => "teammob",
        "username"  => "root",
        "password"  => "war0662",
        "charset"   => "utf8",
        "collation" => "utf8_unicode_ci",
        "prefix" => ''
    ],
    /**
     * This setting is for the setAddress() function
     * default - uses built in parse functions
     * google - uses google's api for parsing addresses NOTE: to be added in version 2
     */
    "parser" => "default",
    "compiledDirectory" => __DIR__.'/../Address/Views/compiled/'
];