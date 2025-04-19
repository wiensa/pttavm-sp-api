<?php

namespace PttavmApi\PttavmSpApi\Exceptions;

use Exception;

class PttAvmException extends Exception
{
    /**
     * API yanıtı
     * 
     * @var array|null
     */
    protected ?array $response = null;

    /**
     * PttAvmException constructor.
     * 
     * @param string $message Hata mesajı
     * @param int $code Hata kodu
     * @param array|null $response API yanıtı
     * @param \Throwable|null $previous Önceki istisna
     * @return void
     */
    public function __construct(string $message, int $code = 0, ?array $response = null, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    /**
     * API yanıtını döndürür
     * 
     * @return array|null
     */
    public function getResponse(): ?array
    {
        return $this->response;
    }
} 