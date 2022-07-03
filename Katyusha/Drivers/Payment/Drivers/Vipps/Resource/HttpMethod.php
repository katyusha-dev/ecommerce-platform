<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Resource;

use Eloquent\Enumeration\AbstractEnumeration;

/**
 * Class HttpMethod.
 *
 * Enum class.
 */
class HttpMethod extends AbstractEnumeration
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const DELETE = 'DELETE';
}
