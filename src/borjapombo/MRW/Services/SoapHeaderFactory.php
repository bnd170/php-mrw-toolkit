<?php

namespace borjapombo\MRW\Services;

use borjapombo\MRW\Entity\AuthHeader;
use SoapHeader;

class SoapHeaderFactory
{
    const NAMESPACE = 'http://www.mrw.es/';

    /**
     * @param AuthHeader $authHeader
     * @return SoapHeader
     */
    public static function create(AuthHeader $authHeader)
    {
        $auth = [
            'CodigoFranquicia' => $authHeader->franchiseCode,
            'CodigoAbonado' => $authHeader->subscriberCode,
            'CodigoDepartamento' => $authHeader->departmentCode,
            'UserName' => $authHeader->userName,
            'Password' => $authHeader->password,
        ];
        $soapHeader = new SoapHeader(self::NAMESPACE, 'AuthInfo', $auth);

        return $soapHeader;
    }
}
