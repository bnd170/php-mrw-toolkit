<?php

namespace borjapombo\MRW\Services;

use borjapombo\MRW\Entity\Delivery;
use borjapombo\MRW\Entity\AuthHeader;

class TicketService
{

    /**
     * @param Delivery $delivery
     * @param AuthHeader $authHeader
     * @return string
     */
    public function getTicketUrl(Delivery $delivery, AuthHeader $authHeader): string
    {
        return $delivery->getUrl()
            . '?Franq=' . $authHeader->franchiseCode
            . '&Ab=' . $authHeader->subscriberCode
            . '&Dep=' . $authHeader->departmentCode
            . '&Usr=' . $authHeader->userName
            . '&Pwd=' . $authHeader->password
            . '&NumEnv=' . $delivery->getShippingNumber();
    }
}
