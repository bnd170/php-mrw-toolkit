<?php

namespace borjapombo\MRW\Services;

class SoapTicketRequestFactory
{

    /**
     * @param string $orderId
     * @return array
     */
    public static function create(string $orderId): array
    {
        return [
            'GetEtiquetaEnvio' => [
                'request' => [
                    'NumeroEnvio' => $orderId,
                    'SeparadorNumerosEnvio' => '',
                    'TipoEtiquetaEnvio' => '0',
                    'ReportTopMargin' => 1100,
                    'ReportLeftMargin' => 650,
                ]
            ]
        ];
    }
}