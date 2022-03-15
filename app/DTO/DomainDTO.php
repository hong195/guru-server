<?php

namespace App\DTO;

use App\Models\Domain;

class DomainDTO
{
    private string $productID;

    public function __construct(
        private string $url,
        private mixed  $userNickname,
        private string $status = '',
        private string $code = '',
    )
    {
    }

    public static function fromArray(array $array)
    {
        return new self(...$array);
    }
    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getUserNickname(): string
    {
        return $this->userNickname;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getProductID(): string
    {
        return Domain::PRO_PLUGIN_PRODUCT_ID;
    }
}
