<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg\Tests;

use BrokeYourBike\Tingg\Models\PaymentWebhook;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class WebhookTest extends TestCase
{
    /** @test */
    public function it_can_decode_webhook_request(): void
    {
        $webhookBody = '{
            "function": "BEEP.pushPaymentStatus",
            "countryCode": "KE",
            "payload": {
                "packet": {
                    "statusCode": "183",
                    "statusDescription": "Payment has been accepted by the merchant",
                    "payerTransactionID": "TEST2",
                    "beepTransactionID": "12341234123",
                    "receiptNumber": "asdsaf234",
                    "receiverNarration": "Payment accepted successfully.",
                    "function": "POST",
                    "msisdn": "1412341234",
                    "serviceCode": "MTN-B2C",
                    "paymentDate": "2022-04-01 14:00:00.0",
                    "clientCode": "SANDBOXTEST",
                    "extraData": "{\"hubID\":0,\"callbackUrl\":\"https://example.com/webhook\"}"
                },
                "credentials": {
                    "username": "",
                    "password": ""
                }
            }
        }';

        $data = \json_decode($webhookBody, true);
        $webhook = new PaymentWebhook($data);

        $this->assertSame('KE', $webhook->countryCode);
        $this->assertSame('183', $webhook->payload->packet->statusCode);
        $this->assertSame('Payment has been accepted by the merchant', $webhook->payload->packet->statusDescription);
        $this->assertSame('TEST2', $webhook->payload->packet->payerTransactionID);
        $this->assertSame('12341234123', $webhook->payload->packet->beepTransactionID);
    }
}
