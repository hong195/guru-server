<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory;

    const ACTIVATED_STATUS = 'activated';
    const NOT_ACTIVATED_STATUS = 'unactivated';
    const PRODUCT_ID = 31778602;

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

    public function activate() : void
    {
        $this->status = 'registered';
    }

    public function isActivated(): bool
    {
        return $this->status === self::ACTIVATED_STATUS;
    }

    public function isNotActivated(): bool
    {
        return $this->status === self::NOT_ACTIVATED_STATUS;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }
}
