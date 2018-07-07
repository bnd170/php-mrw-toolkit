<?php

namespace borjapombo\MRW;

use borjapombo\MRW\Entity\AuthHeader;
use borjapombo\MRW\Entity\Delivery;
use borjapombo\MRW\Entity\PickupAddress;
use borjapombo\MRW\Entity\ServiceData;
use borjapombo\MRW\Entity\ShippingAddress;
use borjapombo\MRW\Entity\ShippingUser;
use borjapombo\MRW\Services\SoapHeaderFactory;
use borjapombo\MRW\Services\SoapRequestFactory;
use borjapombo\MRW\Services\SoapResponseFactory;
use borjapombo\MRW\Services\SoapTicketRequestFactory;
use SoapClient;

class Client
{
    const TRANSACTION_METHOD = 'TransmEnvio';
    const TICKET_METHOD = 'EtiquetaEnvio';
    private $client;
    private $authHeader;

    public function __construct(SoapClient $soapClient, AuthHeader $authHeader)
    {
        $this->client = $soapClient;
        $this->authHeader = $authHeader;
    }

    public function createTransaction(ServiceData $data, ShippingAddress $shippingAddress, PickupAddress $pickupAddress = null, ShippingUser $user): Delivery
    {
        $this->client->__setSoapHeaders([SoapHeaderFactory::create($this->authHeader)]);
        $request = SoapRequestFactory::create($data, $shippingAddress, $pickupAddress, $user);
        $response = $this->client->__soapCall(self::TRANSACTION_METHOD, $request);

        return SoapResponseFactory::create($response);
    }

    public function getTicketFile($orderId)
    {
        $this->client->__setSoapHeaders([SoapHeaderFactory::create($this->authHeader)]);
        $request = SoapTicketRequestFactory::create($orderId);
        $response = $this->client->__soapCall(self::TICKET_METHOD, $request);

        return $response;
    }

}
