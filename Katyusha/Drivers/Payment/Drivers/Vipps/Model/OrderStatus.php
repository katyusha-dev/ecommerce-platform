<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class OrderStatus.
 *
 * @todo: Currently this package is not used anywhere in the project. Use it for
 * reference and comparision only.
 */
abstract class OrderStatus extends AbstractEnumeration
{
    public const INITIATE = 'INITIATE';
    public const REGISTER = 'REGISTER';
    public const RESERVE = 'RESERVE';
    public const SALE = 'SALE';
    public const CANCEL = 'CANCEL';
    public const VOID = 'VOID';
    public const AUTOREVERSAL = 'AUTOREVERSAL';
    public const AUTOCANCEL = 'AUTOCANCEL';
    public const FAILED = 'FAILED';
    public const REJECTED = 'REJECTED';
}
