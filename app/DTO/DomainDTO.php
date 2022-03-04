<?php

namespace App\DTO;

class DomainDTO
{
    public function __construct(
        private string $url,
        private string $productID,
    ){}

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
        return $this->productID;
    }
}
