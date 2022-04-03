<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg\Tests;

use Psr\Http\Message\ResponseInterface;
use Carbon\Carbon;
use BrokeYourBike\Tingg\Models\PaymentsResponse;
use BrokeYourBike\Tingg\Interfaces\PaymentInterface;
use BrokeYourBike\Tingg\Interfaces\ConfigInterface;
use BrokeYourBike\Tingg\Client;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class QueryPaymentStatusTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'secure-password';

    /** @test */
    public function it_can_prepare_request(): void
    {
        $payment = $this->getMockBuilder(PaymentInterface::class)->getMock();
        $payment->method('getReference')->willReturn('TEST2');
        $payment->method('getRemoteReference')->willReturn('123412341234');
        $payment->method('getCountryCodeAlpha2')->willReturn('NG');
        $payment->method('getDate')->willReturn(Carbon::create(2019, 02, 14, 22, 30, 45));

        $mockedConfig = $this->getMockBuilder(ConfigInterface::class)->getMock();
        $mockedConfig->method('getUrl')->willReturn('https://api.example/');
        $mockedConfig->method('getUsername')->willReturn($this->username);
        $mockedConfig->method('getPassword')->willReturn($this->password);
        $mockedConfig->method('getCallBackUrl')->willReturn('https://call.back/');

        $mockedResponse = $this->getMockBuilder(ResponseInterface::class)->getMock();
        $mockedResponse->method('getStatusCode')->willReturn(200);
        $mockedResponse->method('getBody')
            ->willReturn('{
                "authStatus": {
                    "authStatusCode": 131,
                    "authStatusDescription": "Authentication was successful"
                },
                "results": [
                    {
                        "statusCode": 183,
                        "statusDescription": "Transaction acknowledged successfully",
                        "payerTransactionID": "TEST2",
                        "beepTransactionID": 123412341234,
                        "MSISDN": "256787777777",
                        "accountNumber": "256787777777",
                        "amount": 1000,
                        "dateCreated": "2022-04-01 14:06:50",
                        "serviceCode": "MTN-B2C",
                        "serviceName": "MTN Uganda - Account 2 Wallet",
                        "payerClientCode": "SANDBOXTEST",
                        "receiptNumber": "123412341234",
                        "receiverNarration": "Payment accepted successfully.",
                        "totalRecordsPendingQuery": 0,
                        "totalRecordsPendingAck": 0,
                        "recordsPendingQuery": 0,
                        "recordsPendingAcknowlegment": 0,
                        "paymentExtraData": "{\"hubID\":0}"
                    }
                ]
            }');

        /** @var \Mockery\MockInterface $mockedClient */
        $mockedClient = \Mockery::mock(\GuzzleHttp\Client::class);
        $mockedClient->shouldReceive('request')->withArgs([
            'POST',
            'https://api.example/',
            [
                \GuzzleHttp\RequestOptions::HEADERS => [
                    'Accept' => 'application/json',
                ],
                \GuzzleHttp\RequestOptions::JSON => [
                    'countryCode' => 'NG',
                    'function' => 'BEEP.queryPaymentStatus',
                    'payload' => [
                        'credentials' => [
                            'username' => $this->username,
                            'password' => $this->password,
                        ],
                        'packet' => [
                            [
                                'payerTransactionID' => 'TEST2',
                                'beepTransactionID' => '123412341234',
                                'clientCode' => '',
                                'extraData' => '',
                            ],
                        ],
                    ],
                ],
            ],
        ])->once()->andReturn($mockedResponse);

        /**
         * @var ConfigInterface $mockedConfig
         * @var \GuzzleHttp\Client $mockedClient
         * */
        $api = new Client($mockedConfig, $mockedClient);

        /** @var PaymentInterface $payment */
        $requestResult = $api->queryPaymentStatus($payment);

        $this->assertInstanceOf(PaymentsResponse::class, $requestResult);
        $this->assertSame('131', $requestResult->authStatus->authStatusCode);
        $this->assertSame('Authentication was successful', $requestResult->authStatus->authStatusDescription);

        [$paymentResut] = $requestResult->results;
        $this->assertSame('183', $paymentResut->statusCode);
        $this->assertSame('Transaction acknowledged successfully', $paymentResut->statusDescription);
    }
}
