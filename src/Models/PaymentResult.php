<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg\Models;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
class PaymentResult extends DataTransferObject
{
    public string $statusCode;
    public string $statusDescription;
    public string $payerTransactionID;
    public string $beepTransactionID;
    public ?string $MSISDN;
    public ?string $accountNumber;
    public ?float $amount;
    public ?string $dateCreated;
    public ?string $serviceCode;
    public ?string $serviceName;
    public ?string $payerClientCode;
    public ?string $receiptNumber;
    public ?string $receiverNarration;
}
