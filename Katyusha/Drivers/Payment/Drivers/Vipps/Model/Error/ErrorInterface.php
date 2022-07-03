<?php

namespace Katyusha\Drivers\Payment\Drivers\Vipps\Model\Error;

/**
 * Interface ErrorInterface.
 */
interface ErrorInterface
{
    public function getMessage(): string;

    public function getCode(): string;
}
