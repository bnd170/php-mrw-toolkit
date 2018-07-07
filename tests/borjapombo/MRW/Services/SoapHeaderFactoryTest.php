<?php

use borjapombo\MRW\Entity\AuthHeader;
use PHPUnit\Framework\TestCase;
use borjapombo\MRW\Services\SoapHeaderFactory;

class SoapHeaderFactoryTest extends TestCase
{
    public function testSoapHeaderFactoryReturnsSoapHeader()
    {
        $franchise = 'franchise';
        $subscriber = 'subscriber';
        $department = 'departmen';
        $user = 'user';
        $password = 'owd';
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $result = SoapHeaderFactory::create($auth);

        $this->assertInstanceOf('SoapHeader', $result);
    }
}
