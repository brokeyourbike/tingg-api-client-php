<?php

// Copyright (C) 2022 Ivan Stasiuk <ivan@stasi.uk>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\Tingg\Enums;

/**
 * @author Ivan Stasiuk <ivan@stasi.uk>
 */
enum AccountValidationStatusCodeEnum: string
{
    /**
     * Invalid serviceID
     */
    case INVALID_SERVICEID = '167';

    /**
     * Action on client profile account was successful
     */
    case SUCCESS = '200';

    /**
     * Validation feature not available
     */
    case VALIDATION_FEATURE_NOT_AVAILABLE = '301';

    /**
     * Invalid Account Number
     */
    case INVALID_ACCOUNT_NUMBER = '306';

    /**
     * Account number provided is valid
     */
    case ACCOUNT_NUMBER_IS_VALID = '307';

    /**
     * Bill info available
     */
    case BILL_INFO_AVAILABLE = '308';
}
