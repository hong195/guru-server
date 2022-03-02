<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

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
        $this->save();
    }

    public function deregister() : void
    {
        self::delete();
    }
}
