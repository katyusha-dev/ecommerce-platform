<?php
/**
 * Created by PhpStorm.
 * User: zaporylie
 * Date: 24.07.17
 * Time: 14:54.
 */

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Api;

use Katyusha\Drivers\Payment\Drivers\Vipps\Exceptions\VippsException;
use Katyusha\Drivers\Payment\Drivers\Vipps\Model\Authorization\ResponseGetToken;

interface AuthorizationInterface
{
    /**
     * @throws VippsException
     */
    public function getToken(string $client_secret): ResponseGetToken;
}
