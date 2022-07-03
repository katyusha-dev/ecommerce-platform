<?php

namespace Features\DataMapping\Exceptions;

use function array_merge;
use Exception;
use Throwable;

class DataMappingException extends Exception
{
    protected array|null $data = null;

    public function __construct($message = '', $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function help(string $message, array $data): void
    {
        dd(array_merge(['message' => $message], $data));
    }
}
