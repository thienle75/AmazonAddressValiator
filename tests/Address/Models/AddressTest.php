<?php

namespace Address;

class AddressTest extends BaseTestCase
{
    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress1_civic()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'civic';
        $expectedAddress->street_number = '123';
        $expectedAddress->street_name = 'Fake Street North';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->suite = 'Unit 12';
        $expectedAddress->name = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->pobox = '';
        $expectedAddress->rural_route = '';
        $expectedAddress->station = '';

        // first type
        $address = new Models\Address();
        $address->setAddress('123 Fake Street North Unit 12');
        $this->assertEquals($expectedAddress, $address);

        // first type
        $address2 = new Models\Address();
        $address2->setAddress('Unit 12 123 Fake Street North');
        $this->assertEquals($expectedAddress, $address2);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress2_civic()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'civic';
        $expectedAddress->street_number = '123';
        $expectedAddress->street_name = 'Fake Street North';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->suite = '12';
        $expectedAddress->name = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->pobox = '';
        $expectedAddress->rural_route = '';
        $expectedAddress->station = '';

        $address = new Models\Address();
        $address->setAddress('12-123 Fake Street North');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress3_civic()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'civic';
        $expectedAddress->street_number = '36A';
        $expectedAddress->street_name = 'Main St.';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->name = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->suite = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->pobox = '';
        $expectedAddress->rural_route = '';
        $expectedAddress->station = '';

        $address = new Models\Address();
        $address->setAddress('36A Main St.');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress4_pobox()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'pobox';
        $expectedAddress->pobox = 'POBOX 1234';
        $expectedAddress->station = 'STN A';
        $expectedAddress->name = '';
        $expectedAddress->street_number = '';
        $expectedAddress->street_name = '';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->suite = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->rural_route = '';

        $address = new Models\Address();
        $address->setAddress('POBOX 1234 STN A');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress5_pobox()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'pobox';
        $expectedAddress->pobox = 'PO BOX 123';
        $expectedAddress->station = 'STN 3';
        $expectedAddress->name = '';
        $expectedAddress->street_number = '';
        $expectedAddress->street_name = '';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->suite = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->rural_route = '';

        $address = new Models\Address();
        $address->setAddress('STN 3 PO BOX 123');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress6_pobox()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'pobox';
        $expectedAddress->pobox = 'p.o. box 43';
        $expectedAddress->station = 'STN 3';
        $expectedAddress->name = '';
        $expectedAddress->street_number = '';
        $expectedAddress->street_name = '';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->suite = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->rural_route = '';

        $address = new Models\Address();
        $address->setAddress('p.o. box 43 STN 3');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the address parser
     * @group address
     * @group address.models
     * @group address.models.Address
     * @group address.models.Address.setAddress
     */
    public function test_setAddress7_rural()
    {
        new Helpers\EloquentHelper();

        $expectedAddress = new Models\Address();
        $expectedAddress->type = 'rural';
        $expectedAddress->rural_route = 'RR 2';
        $expectedAddress->station = 'Station 3';
        $expectedAddress->name = '';
        $expectedAddress->street_number = '';
        $expectedAddress->street_name = '';
        $expectedAddress->street_type = '';
        $expectedAddress->street_direction = '';
        $expectedAddress->city = '';
        $expectedAddress->province = '';
        $expectedAddress->postal_code = '';
        $expectedAddress->country = '';
        $expectedAddress->suite = '';
        $expectedAddress->buzzer = '';
        $expectedAddress->pobox = '';

        $address = new Models\Address();
        $address->setAddress('RR 2 Station 3');
        $this->assertEquals($expectedAddress, $address);
    }

    /**
     * This function tests the retrieval of addressLine1 for a civic address
     * @group address
     * @group address.models
     * @group address.models.Address
     */
    public function test_addressLine1_retrieval_civic()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 12'
        ]);

        $addressLine1 = '123 Fake Street North';

        $this->assertEquals($addressLine1, $address->getAddressLine1());
    }

    /**
     * This function tests the retrieval of addressLine1 for a pobox address
     * @group address
     * @group address.models
     * @group address.models.Address
     */
    public function test_addressLine1_retrieval_pobox()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'pobox',
            'name' => 'My Address',
            'pobox' => '123',
            'station' => 'STN A',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA'
        ]);

        $addressLine1 = 'PO BOX 123 STN A';

        $this->assertEquals($addressLine1, $address->getAddressLine1());
    }

    /**
     * This function tests the retrieval of addressLine1 for a rural address
     * @group address
     * @group address.models
     * @group address.models.Address
     */
    public function test_addressLine1_retrieval_rural()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'rural',
            'name' => 'My Address',
            'rural_route' => 'RR 123',
            'station' => 'STN A',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA'
        ]);

        $addressLine1 = 'RR 123 STN A';

        $this->assertEquals($addressLine1, $address->getAddressLine1());
    }

    /**
     * This function tests the retrieval of addressLine2 for a civic address
     * @group address
     * @group address.models
     * @group address.models.Address
     */
    public function test_addressLine2_retrieval_civic()
    {
        new Helpers\EloquentHelper();

        $address = Models\Address::create([
            'type' => 'civic',
            'name' => 'My Address',
            'street_number' => '123',
            'street_name' => 'Fake',
            'street_type' => 'Street',
            'street_direction' => 'North',
            'city' => 'Toronto',
            'postal_code' => 'A1A1A1',
            'province' => 'ON',
            'country' => 'CA',
            'suite' => 'Unit 12',
            'buzzer' => '43'
        ]);

        $addressLine2 = 'Unit 12 Buzzer 43';

        $this->assertEquals($addressLine2, $address->getAddressLine2());
    }
}