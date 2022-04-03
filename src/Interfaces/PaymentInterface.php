<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg\Interfaces;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
interface PaymentInterface
{
    public function getReference(): string;
    public function getRemoteReference(): ?string;
    public function getCountryCodeAlpha2(): string;
    public function getCurrencyCode(): string;
    public function getAmount(): float;
    public function getServiceCode(): string;
    public function getProductCode(): ?string;
    public function getSenderPhoneNumber(): string;
    public function getSenderName(): string;
    public function getRecipientPhoneNumber(): string;
    public function getDate(): \DateTimeInterface;
}
