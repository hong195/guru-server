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
    ##const NOT_ACTIVATED_STATUS = 'unactivated';
    const PRO_PLUGIN_PRODUCT_ID = 9221747;

    protected $guarded = [];

    public function product(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->HasOne(Product::class);
    }

    public static function request(string $url, int $productId): void
    {
        self::create([
            'url' => $url,
            'product_id' => $productId,
            'status' => 'unregistered',
        ]);
    }

    public function activate(): void
    {
        $this->status = self::ACTIVATED_STATUS;
    }

    public function deActivate(): void
    {
        $this->status = self::NOT_ACTIVATED_STATUS;
    }

    public function setCode(string $code)
    {
        $this->code = $code;
    }

    public function scopeIsActivated($query, string $userNickname)
    {
        return $query->where('user_nickname', $userNickname)
            ->where('status', Domain::ACTIVATED_STATUS)
            ->where('product_id', self::PRO_PLUGIN_PRODUCT_ID);
    }
}
