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
class PostPaymentTest extends TestCase
{
    private string $username = 'john';
    private string $password = 'secure-password';

    /** @test */
    public function it_can_prepare_request(): void
    {
        $payment = $this->getMockBuilder(PaymentInterface::class)->getMock();
        $payment->method('getReference')->willReturn('yourUniqueID');
        $payment->method('getCountryCodeAlpha2')->willReturn('NG');
        $payment->method('getCurrencyCode')->willReturn('USD');
        $payment->method('getAmount')->willReturn(1000.50);
        $payment->method('getServiceCode')->willReturn('SERVICE-1');
        $payment->method('getSenderPhoneNumber')->willReturn('+12345');
        $payment->method('getSenderName')->willReturn('John Doe');
        $payment->method('getRecipientPhoneNumber')->willReturn('+45678');
        $payment->method('getProductCode')->willReturn('P-123');
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
                    "statusDescription": "auth success"
                },
                "results": [{
                    "statusCode": 139,
                    "statusDescription": "Payment pending acknowledgement",
                    "payerTransactionID": "yourUniqueID",
                    "beepTransactionID": "ourBeepUniqueID",
                    "receiptNumber": ""
                }]
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
                    'function' => 'BEEP.postPayment',
                    'payload' => [
                        'credentials' => [
                            'username' => $this->username,
                            'password' => $this->password,
                        ],
                        'packet' => [
                            [
                                'serviceCode' => 'SERVICE-1',
                                'MSISDN' => '+12345',
                                'invoiceNumber' => '',
                                'customerNames' => 'John Doe',
                                'accountNumber' => '+45678',
                                'payerTransactionID' => 'yourUniqueID',
                                'amount' => 1000.50,
                                'hubID' => '',
                                'narration' => 'yourUniqueID',
                                'datePaymentReceived' => '2019-02-14 22:30:45',
                                'currencyCode' => 'USD',
                                'extraData' => \json_encode([
                                    'callBackUrl' => 'https://call.back/',
                                    'productCode' => 'P-123',
                                ]),
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
        $requestResult = $api->postPayment($payment);

        $this->assertInstanceOf(PaymentsResponse::class, $requestResult);
        $this->assertSame('131', $requestResult->authStatus->authStatusCode);
        $this->assertSame('auth success', $requestResult->authStatus->statusDescription);

        [$paymentResut] = $requestResult->results;
        $this->assertSame('139', $paymentResut->statusCode);
        $this->assertSame('Payment pending acknowledgement', $paymentResut->statusDescription);
        $this->assertSame('yourUniqueID', $paymentResut->payerTransactionID);
        $this->assertSame('ourBeepUniqueID', $paymentResut->beepTransactionID);
        $this->assertSame('', $paymentResut->receiptNumber);
    }
}
