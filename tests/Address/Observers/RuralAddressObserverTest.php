<?php

namespace Address;

use \Illuminate\Support\MessageBag;

class RuralAddressObserverTest extends BaseTestCase
{
    /**
     * This function tests the success case
     * @group address
     * @group address.observers
     * @group address.observers.RuralAddressObserver
     */
    public function test_create_new_rural_address()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'rural',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'rural_route' => 'RR 123',
            'station' => 'STN A'
        ]);

        $this->assertEquals([], $address->errors);
    }

    /**
     * This function tests the error case for no rural route for a rural address
     * @group address
     * @group address.observers
     * @group address.observers.RuralAddressObserver
     */
    public function test_create_new_rural_address_with_no_rural_route()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'rural',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'rural_route' => '',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'rural route'], 'en');

        $errors = new MessageBag;
        $errors->add('rural_route', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no station for a rural address
     * @group address
     * @group address.observers
     * @group address.observers.RuralAddressObserver
     */
    public function test_create_new_rural_address_with_no_station()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'rural',
            'name' => 'My Address',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'rural_route' => 'RR 123',
            'station' => ''
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'station'], 'en');

        $errors = new MessageBag;
        $errors->add('station', $error);

        $this->assertEquals($errors, $address->errors);
    }
}