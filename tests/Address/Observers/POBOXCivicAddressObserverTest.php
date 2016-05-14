<?php

namespace Address;

use \Illuminate\Support\MessageBag;

class POBOXCivicAddressObserverTest extends BaseTestCase
{
    /**
     * This function tests the success case
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => 'PO BOX 123',
            'station' => 'STN A'
        ]);

        $this->assertEquals([], $address->errors);
    }

    /**
     * This function tests the error case for no street number for a pobox_civic address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address_with_no_street_number()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => 'PO BOX 123',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'street number'], 'en');

        $errors = new MessageBag;
        $errors->add('street_number', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no street name for a pobox_civic address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address_with_no_street_name()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => '',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => 'PO BOX 123',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'street name'], 'en');

        $errors = new MessageBag;
        $errors->add('street_name', $error);

        $this->assertEquals($errors, $address->errors);
    }


    /**
     * This function tests the error case for no street type for a pobox_civic address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address_with_no_street_type()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => '',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => 'PO BOX 123',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'street type'], 'en');

        $errors = new MessageBag;
        $errors->add('street_type', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no pobox for a pobox_civic address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address_with_no_pobox()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => '',
            'station' => 'STN A'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'pobox'], 'en');

        $errors = new MessageBag;
        $errors->add('pobox', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no station for a pobox_civic address
     * @group address
     * @group address.observers
     * @group address.observers.POBOXCivicAddressObserver
     */
    public function test_create_new_pobox_civic_address_with_no_station()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox_civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 15',
            'buzzer' => '654321',
            'pobox' => 'PO BOX 123',
            'station' => ''
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'station'], 'en');

        $errors = new MessageBag;
        $errors->add('station', $error);

        $this->assertEquals($errors, $address->errors);
    }
}