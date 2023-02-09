<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Str;

class DomainHasBeenAlreadyActivated extends Exception
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null, private string $domainUrl = '')
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return string
     */
    public function getDomainUrl(): string
    {
        return $this->domainUrl;
    }
}
