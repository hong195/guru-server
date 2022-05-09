<?php

namespace App\Http\Requests;

use App\DTO\DomainDTO;
use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\ArrayShape;

class DomainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['state' => "string[]"])] public function rules(): array
    {
        return [
            'state' => ['required', 'url'],
            //'productID' => ['required', 'exists:App\Models\Product,id'],
        ];
    }
}
