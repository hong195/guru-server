<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    const REGISTERED_STATUS = 'registered';
    const UN_REGISTERED_STATUS = 'unregistered';

    protected $guarded = [];

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->HasOne(Product::class);
    }

    public static function request(string $url, int $productId) : void
    {
        self::create([
            'url' => $url,
            'product_id' => $productId,
            'status' => 'unregistered',
        ]);
    }

    public function register() : void
    {
        $this->status = 'registered';
    }

    public function isRegistered(): bool
    {
        return $this->status === self::REGISTERED_STATUS;
    }

    public function isNotRegistered(): bool
    {
        return $this->status === self::UN_REGISTERED_STATUS;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }
}
