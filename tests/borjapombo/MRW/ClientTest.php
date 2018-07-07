<?php


// $ export FRANCHISE=00620 SUBSCRIBER=017017 USER=SG00620LATOSTADORA PASSWORD=SG00620LATOSTADORA phpunit

use PHPUnit\Framework\TestCase;
use borjapombo\MRW\Client;
use borjapombo\MRW\Entity\AuthHeader;
use borjapombo\MRW\Entity\ServiceData;
use borjapombo\MRW\Entity\ShippingAddress;
use borjapombo\MRW\Entity\ShippingUser;

class ClientTest extends TestCase
{
    const TEST_SOAP_CLIENT = 'http://sagec-test.mrw.es/MRWEnvio.asmx?WSDL';

    public function testCanConstructApiClient()
    {
        $soap = new SoapClient(self::TEST_SOAP_CLIENT, array('trace' => 1, "exceptions" => 0));
        $franchise = '';
        $subscriber = '';
        $department = '';
        $user = '';
        $password = '';
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $apiClient = new Client($soap, $auth);

        $this->assertInstanceOf('\borjapombo\MRW\Client', $apiClient);
    }

    public function testCanCreateTransaction()
    {
        $soap = new SoapClient(self::TEST_SOAP_CLIENT, array('trace' => 1, "exceptions" => 0));
        $franchise = getenv('FRANCHISE');
        $subscriber = getenv('SUBSCRIBER');
        $department = getenv('DEPARTMENT');
        $user = getenv('USER');
        $password = getenv('PASSWORD');
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $apiClient = new Client($soap, $auth);

        $dateTime = new DateTime();
        $date = $dateTime->format('d/m/Y');
        $reference = 'BWZXTFSZU';
        $onFranchise = 'N';
        $serviceCode = '0800';
        $serviceDescription = '';
        $items = '';
        $numberOfItems = '1';
        $weight = '1';
        $saturdayDelivery = 'N';
        $return = 'N';
        $refund = 'O';
        $refundAmount = '25,9';
        $notificationsMail = 'test@test.com';
        $notificationsSMS = '666666666';

        $serviceData = new ServiceData($date, $reference, $onFranchise, $serviceCode, $serviceDescription, $items,
            $numberOfItems, $weight, $saturdayDelivery, $return, $refund, $refundAmount, $notificationsMail, $notificationsSMS);

        $addressCode = '';
        $viaType = '';
        $via = 'Calle Ramon y Cajal 22';
        $number = '';
        $other = '';
        $postalCode = '08402';
        $city = 'Granollers';
        $countryCode = 'ESP';

        $shippingAddress = new ShippingAddress($addressCode, $viaType, $via, $number, $other, $postalCode, $city,
            $countryCode);

        $nif = '';
        $name = 'Jorge Xavier';
        $telephone = '666666666';
        $contact = 'Jorge';
        $atentionTo = 'Jorge';
        $observations = '';

        $shippingUser = new ShippingUser($nif, $name, $telephone, $contact, $atentionTo, $observations);

        $delivery = $apiClient->createTransaction($serviceData, $shippingAddress, $shippingUser);

        $this->assertInstanceOf('\borjapombo\MRW\Client', $apiClient);
        $this->assertInstanceOf('\borjapombo\MRW\Entity\Delivery', $delivery);
        $this->assertEquals(1, $delivery->getState());
    }

    public function testCanNotLogOnTransaction()
    {
        $soap = new SoapClient(self::TEST_SOAP_CLIENT, array('trace' => 1, "exceptions" => 0));
        $franchise = '';
        $subscriber = '';
        $department = '';
        $user = '';
        $password = '';
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $apiClient = new Client($soap, $auth);


        $date = date("dd/mm/YY");
        $reference = 'BWZXTFSZU';
        $onFranchise = 'N';
        $serviceCode = '0800';
        $serviceDescription = '';
        $items = '';
        $numberOfItems = '1';
        $weight = '1';
        $saturdayDelivery = 'N';
        $return = 'N';
        $refund = 'O';
        $refundAmount = '25,9';
        $notificationsMail = 'test@test.com';
        $notificationsSMS = '666666666';

        $serviceData = new ServiceData($date, $reference, $onFranchise, $serviceCode, $serviceDescription, $items,
            $numberOfItems, $weight, $saturdayDelivery, $return, $refund, $refundAmount, $notificationsMail, $notificationsSMS);

        $addressCode = '';
        $viaType = '';
        $via = 'Calle Ramon y Cajal 22';
        $number = '';
        $other = '';
        $postalCode = '08402';
        $city = 'Granollers';
        $countryCode = 'ESP';

        $shippingAddress = new ShippingAddress($addressCode, $viaType, $via, $number, $other, $postalCode, $city,
            $countryCode);

        $nif = '';
        $name = 'Jorge Xavier';
        $telephone = '666666666';
        $contact = 'Jorge';
        $atentionTo = 'Jorge';
        $observations = '';

        $shippingUser = new ShippingUser($nif, $name, $telephone, $contact, $atentionTo, $observations);

        $delivery = $apiClient->createTransaction($serviceData, $shippingAddress, $shippingUser);

        $this->assertInstanceOf('\borjapombo\MRW\Client', $apiClient);
        $this->assertInstanceOf('\borjapombo\MRW\Entity\Delivery', $delivery);
        $this->assertTrue($delivery->getMessage() == '1) El usuario especificado no dispone de acceso al sistema, consulte con su franquicia.');
        $this->assertTrue($delivery->getState() == 0);
    }

    public function testCanGetTicketFile()
    {
        $soap = new SoapClient(self::TEST_SOAP_CLIENT, array('trace' => 1, "exceptions" => 0));
        $franchise = getenv('FRANCHISE');
        $subscriber = getenv('SUBSCRIBER');
        $department = getenv('DEPARTMENT');
        $user = getenv('USER');
        $password = getenv('PASSWORD');
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $apiClient = new Client($soap, $auth);

        $orderId = getenv('ORDERID');
        $ticket = $apiClient->getTicketFile($orderId);

        $this->assertEquals(1, $ticket->GetEtiquetaEnvioResult->Estado);
    }


    public function testTicketFileNotExist()
    {
        $soap = new SoapClient(self::TEST_SOAP_CLIENT, array('trace' => 1, "exceptions" => 0));
        $franchise = getenv('FRANCHISE');
        $subscriber = getenv('SUBSCRIBER');
        $department = getenv('DEPARTMENT');
        $user = getenv('USER');
        $password = getenv('PASSWORD');
        $auth = new AuthHeader($franchise, $subscriber, $department, $user, $password);

        $apiClient = new Client($soap, $auth);

        $orderId = '00620';
        $ticket = $apiClient->getTicketFile($orderId);

        $this->assertEquals(0, $ticket->GetEtiquetaEnvioResult->Estado);
    }

}
