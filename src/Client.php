<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\ClientInterface;
use BrokeYourBike\Tingg\Models\PaymentsResponse;
use BrokeYourBike\Tingg\Interfaces\PaymentInterface;
use BrokeYourBike\Tingg\Interfaces\ConfigInterface;
use BrokeYourBike\ResolveUri\ResolveUriTrait;
use BrokeYourBike\HttpEnums\HttpMethodEnum;
use BrokeYourBike\HttpClient\HttpClientTrait;
use BrokeYourBike\HttpClient\HttpClientInterface;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class Client implements HttpClientInterface
{
    use HttpClientTrait;
    use ResolveUriTrait;

    private ConfigInterface $config;

    public function __construct(ConfigInterface $config, ClientInterface $httpClient)
    {
        $this->config = $config;
        $this->httpClient = $httpClient;
    }

    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    public function postPayment(PaymentInterface $payment): PaymentsResponse
    {
        $extraData = [];

        if ($this->config->getCallbackUrl()) {
            $extraData['callBackUrl'] = $this->config->getCallbackUrl();
        }

        if ($payment->getProductCode()) {
            $extraData['productCode'] = $payment->getProductCode();
        }

        $response = $this->performRequest(HttpMethodEnum::POST, '', [
            'countryCode' => $payment->getCountryCodeAlpha2(),
            'function' => 'BEEP.postPayment',
            'payload' => [
                'credentials' => [
                    'username' => $this->config->getUsername(),
                    'password' => $this->config->getPassword(),
                ],
                'packet' => [
                    [
                        'serviceCode' => $payment->getServiceCode(),
                        'MSISDN' => $payment->getSenderPhoneNumber(),
                        'invoiceNumber' => '',
                        'customerNames' => $payment->getSenderName(),
                        'accountNumber' => $payment->getRecipientPhoneNumber(),
                        'payerTransactionID' => $payment->getReference(),
                        'amount' => $payment->getAmount(),
                        'hubID' => '',
                        'narration' => $payment->getReference(),
                        'datePaymentReceived' => $payment->getDate()->format('Y-m-d H:i:s'),
                        'currencyCode' => $payment->getCurrencyCode(),
                        'extraData' => \json_encode($extraData),
                    ],
                ],
            ],
        ]);
        return new PaymentsResponse($response);
    }

    public function queryPaymentStatus(PaymentInterface $payment): PaymentsResponse
    {
        $response = $this->performRequest(HttpMethodEnum::POST, '', [
            'countryCode' => $payment->getCountryCodeAlpha2(),
            'function' => 'BEEP.queryPaymentStatus',
            'payload' => [
                'credentials' => [
                    'username' => $this->config->getUsername(),
                    'password' => $this->config->getPassword(),
                ],
                'packet' => [
                    [
                        'payerTransactionID' => $payment->getReference(),
                        'beepTransactionID' => $payment->getRemoteReference(),
                        'clientCode' => '',
                        'extraData' => '',
                    ],
                ],
            ],
        ]);
        return new PaymentsResponse($response);
    }

    /**
     * @param HttpMethodEnum $method
     * @param string $uri
     * @param array<mixed> $data
     * @return ResponseInterface
     */
    private function performRequest(HttpMethodEnum $method, string $uri, array $data): ResponseInterface
    {
        $options = [
            \GuzzleHttp\RequestOptions::HEADERS => [
                'Accept' => 'application/json',
            ],
        ];

        $option = match ($method) {
            HttpMethodEnum::GET => \GuzzleHttp\RequestOptions::QUERY,
            default => \GuzzleHttp\RequestOptions::JSON,
        };

        $options[$option] = $data;

        $uri = (string) $this->resolveUriFor($this->config->getUrl(), $uri);
        return $this->httpClient->request($method->value, $uri, $options);
    }
}
