<?php

use PHPUnit\Framework\TestCase;
use borjapombo\MRW\Entity\ShippingAddress;

class ShippingAddressTest extends TestCase
{
    public function testCanConstructShippingAddress()
    {
        $addressCode = '';
        $viaType = '';
        $via = 'Calle Ramon y Cajal';
        $number = '22';
        $other = '';
        $postalCode = '08402';
        $city = 'Granollers';
        $countryCode = 'ESP';

        $shippingAddress = new ShippingAddress($addressCode, $viaType, $via, $number, $other, $postalCode, $city, $countryCode);

        $this->assertInstanceOf('borjapombo\MRW\Entity\ShippingAddress', $shippingAddress);
        $this->assertEquals($addressCode, $shippingAddress->getAddressCode());
        $this->assertEquals($viaType, $shippingAddress->getViaType());
        $this->assertEquals($via, $shippingAddress->getVia());
        $this->assertEquals($number, $shippingAddress->getNumber());
        $this->assertEquals($other, $shippingAddress->getOther());
        $this->assertEquals($postalCode, $shippingAddress->getPostalCode());
        $this->assertEquals($city, $shippingAddress->getCity());
        $this->assertEquals($countryCode, $shippingAddress->getCountryCode());
    }

}
