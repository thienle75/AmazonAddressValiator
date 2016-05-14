<?php

namespace Address;

use \Illuminate\Support\MessageBag;

class POBOXAddressObserverTest extends BaseTestCase
{
    /**
     * This function tests the success case
     * @group address
     * @group address.observers
     * @group address.observers.POBOXAddressObserver
     */
    public function test_create_new_pobox_address()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'pobox' => 'PO BOX 123',
            'station' => 'STN A'
        ]);

        $this->assertEquals([], $address->errors);
    }

    /**
     * This function tests the error case for no pobox for a pobox address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXAddressObserver
     */
    public function test_create_new_pobox_address_with_no_pobox()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'pobox' => '',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'pobox'], 'en');

        $errors = new MessageBag;
        $errors->add('pobox', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no station for a pobox address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXAddressObserver
     */
    public function test_create_new_pobox_address_with_no_station()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'pobox' => 'PO BOX 123',
            'station' => ''
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'station'], 'en');

        $errors = new MessageBag;
        $errors->add('station', $error);

        $this->assertEquals($errors, $address->errors);
    }
}