<?php

namespace Address;

use \Illuminate\Support\MessageBag;

class AddressObserverTest extends BaseTestCase
{
    /**
     * This function tests the error case for no city for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_no_city()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => '',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'city'], 'en');

        $errors = new MessageBag;
        $errors->add('city', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no postal code for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_postal_code()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => '',
            'province' => 'ON',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'postal code'], 'en');

        $errors = new MessageBag;
        $errors->add('postal_code', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format postal code for a canadian civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_postal_code_canada()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => '123ASD',
            'province' => 'ON',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.regex', [':attribute'=>'postal code'], 'en');

        $errors = new MessageBag;
        $errors->add('postal_code', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format postal code for a USA civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_postal_code_usa()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => '90SD10',
            'province' => 'ON',
            'country' => 'US'
        ]);

        $error = $this->getValidationMessage('validation.regex', [':attribute'=>'postal code'], 'en');

        $errors = new MessageBag;
        $errors->add('postal_code', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the case for valid 5 digit postal code for a USA civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_valid_short_postal_code_usa()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => '90210',
            'province' => 'ON',
            'country' => 'US'
        ]);

        $this->assertEquals([], $address->errors);
    }

    /**
     * This function tests the case for valid 5-4 digit postal code for a USA civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_valid_long_postal_code_usa()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => '90210-1234',
            'province' => 'ON',
            'country' => 'US'
        ]);

        $this->assertEquals([], $address->errors);
    }

    /**
     * This function tests the error case for no province for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_no_province()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => '',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'province'], 'en');

        $errors = new MessageBag;
        $errors->add('province', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format province for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_province()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'Ontario',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.max.string', [':attribute'=>'province', ":max"=>2], 'en');

        $errors = new MessageBag;
        $errors->add('province', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format2 province for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_province2()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'O',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.min.string', [':attribute'=>'province', ":min"=>2], 'en');

        $errors = new MessageBag;
        $errors->add('province', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format3 province for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_province3()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => '12',
            'country' => 'CA'
        ]);

        $error = $this->getValidationMessage('validation.alpha', [':attribute'=>'province'], 'en');

        $errors = new MessageBag;
        $errors->add('province', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for no country for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_no_country()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => ''
        ]);

        $error = $this->getValidationMessage('validation.required', [':attribute'=>'country'], 'en');

        $errors = new MessageBag;
        $errors->add('country', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format country for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_country()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'Canada'
        ]);

        $error = $this->getValidationMessage('validation.max.string', [':attribute'=>'country', ":max"=>2], 'en');

        $errors = new MessageBag;
        $errors->add('country', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format2 country for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_country2()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'C'
        ]);

        $error = $this->getValidationMessage('validation.min.string', [':attribute'=>'country', ":min"=>2], 'en');

        $errors = new MessageBag;
        $errors->add('country', $error);

        $this->assertEquals($errors, $address->errors);
    }

    /**
     * This function tests the error case for wrong format3 country for a civic address
     * @group address
     * @group address.observers
     * @group address.observers.AddressObserver
     */
    public function test_create_new_civic_address_with_wrong_format_country3()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_number_suffix' => 'A',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => '12'
        ]);

        $error = $this->getValidationMessage('validation.alpha', [':attribute'=>'country'], 'en');

        $errors = new MessageBag;
        $errors->add('country', $error);

        $this->assertEquals($errors, $address->errors);
    }
}