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
enum PaymentStatusCodeEnum: string
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
     * Customer MSISDN missing
     */
    case CUSTOMER_MSISDN_MISSING = '109';

    /**
     * Invalid Customer MSISDN
     */
    case INVALID_CUSTOMER_MSISDN = '110';

    /**
     * Invalid invoice amount
     */
    case INVALID_INVOICE_AMOUNT = '111';

    /**
     * Invalid currency code specified
     */
    case INVALID_CURRENCY_CODE = '115';

    /**
     * Account number not specified
     */
    case ACCOUNT_NUMBER_NOT_SPECIFIED = '120';

    /**
     * Payment posted successfully and pending acknowledgement.
     */
    case POSTED_AND_PENDING_ACKNOWLEDGEMENT = '139';

    /**
     * Invoice does not exist
     */
    case INVOICE_DOES_NOT_EXIST = '146';

    /**
     * Invalid serviceID
     */
    case INVALID_SERVICEID = '167';

    /**
     * Generic failure status code with matching appropriate description
     */
    case GENERIC_FAILURE = '174';

    /**
     * Payment Rejected i.e. Failed
     */
    case PAYMENT_REJECTED = '180';

    /**
     * Payment accepted i.e. Success
     */
    case PAYMENT_ACCEPTED = '183';

    /**
     * Payment manually Rejected.
     * Propagated after an escalated transaction has been manually/ auto reconciled within 24hours.
     */
    case PAYMENT_MANUALLY_REJECTED = '216';

    /**
     * Payment manually Accepted.
     * Propagated after an escalated transaction has been manually/ auto reconciled within 24hours.
     */
    case PAYMENT_MANUALLY_ACCEPTED = '217';

    /**
     * Payment escalated
     */
    case PAYMENT_ESCALATED = '219';

    /**
     * Amount specified is greater than maximum allowed for service
     */
    case AMOUNT_SPECIFIED_IS_GREATER_THAN_MAXIMUM_ALLOWED = '231';

    /**
     * Amount specified is less than minimum allowed for service
     */
    case AMOUNT_SPECIFIED_IS_LESS_THAN_MINIMUM_ALLOWED = '232';

    /**
     * Duplicate payment found
     */
    case DUPLICATE_PAYMENT_FOUND = '229';
}
