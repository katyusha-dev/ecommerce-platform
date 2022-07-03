<?php

namespace Features\Purchasing\Enums;

enum PaymentProvidersEnum: string {
    case STRIPE = 'stripe';
    case VIPPS  = 'vipps';
}
