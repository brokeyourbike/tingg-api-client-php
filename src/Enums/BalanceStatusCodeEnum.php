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
enum BalanceStatusCodeEnum: string
{
    /**
     * Generic exception occurred with matching appropriate description
     */
    case GENERIC_EXCEPTION = '104';

    /**
     * Inactive service
     */
    case INACTIVE_SERVICE = '106';

    /**
     * Invalid serviceID
     */
    case INVALID_SERVICEID = '167';

    /**
     * Generic failure occurred with appropriate status description
     */
    case GENERIC_FAILURE = '174';

    /**
     * Successfully able to query the float balance
     */
    case SUCCESS = '200';

    /**
     * Failed to fetch the float balance
     */
    case FAILED = '302';
}
