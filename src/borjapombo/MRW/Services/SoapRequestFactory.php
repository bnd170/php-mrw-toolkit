<?php

namespace borjapombo\MRW\Services;

use borjapombo\MRW\Entity\PickupAddress;
use borjapombo\MRW\Entity\PickupUser;
use borjapombo\MRW\Entity\ServiceData;
use borjapombo\MRW\Entity\ShippingAddress;
use borjapombo\MRW\Entity\ShippingUser;

class SoapRequestFactory
{
    /**
     * @param ServiceData $data
     * @param ShippingAddress $shippingAddress
     * @param PickupAddress|null $pickupAddress
     * @param ShippingUser $shippingUser
     * @param PickupUser $pickupUser
     * @return array
     */
    public static function create(ServiceData $data, ShippingAddress $shippingAddress, PickupAddress $pickupAddress = null, ShippingUser $shippingUser, PickupUser $pickupUser): array
    {
        $requestXLM = [
            'TransmEnvio' => [
                'request' => [
                    'DatosEntrega' => [
                        'Direccion' => [
                            'CodigoDireccion' => $shippingAddress->getAddressCode(),
                            'CodigoTipoVia' => $shippingAddress->getViaType(),
                            'Via' => $shippingAddress->getVia(),
                            'Numero' => $shippingAddress->getNumber(),
                            'Resto' => $shippingAddress->getOther(),
                            'CodigoPostal' => $shippingAddress->getPostalCode(),
                            'Poblacion' => $shippingAddress->getCity(),
                            'CodigoPais' => $shippingAddress->getCountryCode(),
                        ],
                        'Nif' => $pickupUser->getNif(),
                        'Nombre' => $pickupUser->getName(),
                        'Telefono' => $pickupUser->getTelephone(),
                        'Contacto' => $pickupUser->getContact(),
                        'ALaAtencionDe' => $pickupUser->getAtentionTo(),
                        'Observaciones' => $pickupUser->getObservations(),
                    ],
                    'DatosServicio' => [
                        'Fecha' => $data->getDate(),
                        'Referencia' => $data->getReference(),
                        'EnFranquicia' => $data->getOnFranchise(),
                        'CodigoServicio' => $data->getServiceCode(),
                        'DescripcionServicio' => $data->getServiceDescription(),
                        'Bultos' => $data->getItems(),
                        'NumeroBultos' => $data->getNumberOfItems(),
                        'Peso' => $data->getWeight(),
                        'EntregaSabado' => $data->getSaturdayDelivery(),
                        'Retorno' => $data->getReturn(),
                        'Reembolso' => $data->getRefund(),
                        'ImporteReembolso' => $data->getRefundAmount(),
                        'Notificaciones' => [
                            'NotificacionRequest' =>[
                                [
                                    'CanalNotificacion' => '1',
                                    'TipoNotificacion' => '2',
                                    'MailSMS' => $data->getNotificationsMail(),
                                ],
                                [
                                    'CanalNotificacion' => '2',
                                    'TipoNotificacion' => '2',
                                    'MailSMS' => $data->getNotificationsSMS(),
                                ],
                                [
                                    'CanalNotificacion' => '1',
                                    'TipoNotificacion' => '4',
                                    'MailSMS' => $data->getNotificationsMail(),
                                ],
                                [
                                    'CanalNotificacion' => '2',
                                    'TipoNotificacion' => '4',
                                    'MailSMS' => $data->getNotificationsSMS(),
                                ]

                            ]
                        ]
                    ]
                ]
            ]
        ];

        if($pickupAddress) {
            $requestXLM['TransmEnvio']['request']['DatosRecogida'] = [
                'DatosRecogida' => [
                    'Direccion' => [
                        'CodigoDireccion' => $pickupAddress->getAddressCode(),
                        'CodigoTipoVia' => $pickupAddress->getViaType(),
                        'Via' => $pickupAddress->getVia(),
                        'Numero' => $pickupAddress->getNumber(),
                        'Resto' => $pickupAddress->getOther(),
                        'CodigoPostal' => $pickupAddress->getPostalCode(),
                        'Poblacion' => $pickupAddress->getCity(),
                        'CodigoPais' => $pickupAddress->getCountryCode(),
                    ],
                    'Nif' => $shippingUser->getNif(),
                    'Nombre' => $shippingUser->getName(),
                    'Telefono' => $shippingUser->getTelephone(),
                    'Contacto' => $shippingUser->getContact(),
                    'ALaAtencionDe' => $shippingUser->getAtentionTo(),
                    'Observaciones' => $shippingUser->getObservations(),
                ]
            ];
        }

        return $requestXLM;
    }
}