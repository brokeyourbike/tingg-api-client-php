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
enum AuthCodeEnum: string
{
    /**
     * Client authenticated successfully
     */
    case AUTH_SUCCESS = '131';

    /**
     * Client authentication failed
     */
    case AUTH_FAILED = '132';

    /**
     * Generic failure status code with matching appropriate description
     */
    case GENERIC_FAILURE = '174';
}
