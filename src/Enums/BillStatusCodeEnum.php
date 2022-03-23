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
enum BillStatusCodeEnum: string
{
    /**
     * Invalid account number
     */
    case INVALID_ACCOUNT_NUMBER = '306';

    /**
     * Bill information is available.
     * The merchant has a bill for the account.
     */
    case BILL_INFORMATION_IS_AVAILABLE = '308';

    /**
     * Bill information not available
     */
    case BILL_INFORMATION_NOT_AVAILABLE = '309';
}
