<?php


namespace App\Exceptions;


use Throwable;

class TransactionException extends \Exception
{
    /**
     * @var array
     */
    public $payload = [];

    /**
     * TransactionException constructor.
     * @param $payload
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $payload = [], $code = 0, Throwable $previous = null)
    {
        $this->payload = $payload;
        parent::__construct($message, $code, $previous);
    }
}
