<?php

namespace Katyusha\Drivers\Managers;

use Illuminate\Support\Manager;
use Katyusha\Drivers\Contracts\PrintingDriverContract;
use Katyusha\Drivers\Implementations\Printing\PrintnodeDriver;

/**
 * @method PrintingDriverContract driver(string $driver = null)
 */
final class PrintingManager extends Manager
{
    public const PRINTNODE = 'printnode';

    public function getDefaultDriver(): string
    {
        return config('drivers.printing.default');
    }

    public function createPrintnodeDriver(string $apiKey): PrintingDriverContract
    {
        return new PrintnodeDriver($apiKey);
    }
}
