<?php

namespace PttavmApi\PttavmSpApi\Services;

use PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface;

abstract class BaseService
{
    /**
     * API servisi
     *
     * @var \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface
     */
    protected ApiServiceInterface $api;

    /**
     * BaseService constructor.
     *
     * @param \PttavmApi\PttavmSpApi\Contracts\ApiServiceInterface $api
     */
    public function __construct(ApiServiceInterface $api)
    {
        $this->api = $api;
    }
} 