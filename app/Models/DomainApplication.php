<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DomainApplication extends Model
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
        $application = $this->where('code', $code)->findOrFail();
    }
}
