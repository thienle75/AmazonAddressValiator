<?php

namespace Address;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;

class BaseTestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * This function returns a validator message
     * @param $msg_key
     * @param $attributes
     * @param $locale
     * @return string
     */
    public function getValidationMessage($msg_key, $attributes, $locale)
    {
        $translator = new Translator('en');
        $translator->addLoader('array', new ArrayLoader);

        $validation = ['validation' => include(__DIR__ . '/../../src/lang/en/validation.php')];
        $translator->addResource('array', $validation, 'en');

        $error = $translator->trans($msg_key, $attributes, null, $locale);

        return $error;
    }

    public function test_success()
    {
        $this->assertTrue(true);
    }
}