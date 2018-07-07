<?php

namespace borjapombo\MRW\Services;

use borjapombo\MRW\Entity\PickupAddress;
use borjapombo\MRW\Entity\ServiceData;
use borjapombo\MRW\Entity\ShippingAddress;
use borjapombo\MRW\Entity\ShippingUser;

class SoapRequestFactory
{
    /**
     * @param ServiceData $data
     * @param ShippingAddress $shippingAddress
     * @param PickupAddress|null $pickupAddress
     * @param ShippingUser $user
     * @return array
     */
    public static function create(ServiceData $data, ShippingAddress $shippingAddress, PickupAddress $pickupAddress = null, ShippingUser $user): array
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
                        'Nif' => $user->getNif(),
                        'Nombre' => $user->getName(),
                        'Telefono' => $user->getTelephone(),
                        'Contacto' => $user->getContact(),
                        'ALaAtencionDe' => $user->getAtentionTo(),
                        'Observaciones' => $user->getObservations(),
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
                    'Nif' => $user->getNif(),
                    'Nombre' => $user->getName(),
                    'Telefono' => $user->getTelephone(),
                    'Contacto' => $user->getContact(),
                    'ALaAtencionDe' => $user->getAtentionTo(),
                    'Observaciones' => $user->getObservations(),
                ]
            ];
        }

        return $requestXLM;
    }
}