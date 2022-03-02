<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;

    public function createRequest(string $domain, string $code)
    {
        (new self([
            'domain' => $domain,
            'status' => 'pending',
            'code' => $code
        ]))->save();
    }

    public function approve(string $code)
    {
        $domain = $this->where('code', $code)->findOrFail();
    }

    public function deregister()
    {

    }
}
