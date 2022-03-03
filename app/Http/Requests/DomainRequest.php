<?php

namespace App\Http\Requests;

use App\DTO\DomainDTO;
use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\Pure;

class DomainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required', 'string'],
            'productID' => ['required', 'exists:App\Models\Product,id'],
        ];
    }

    public function getDTO(): DomainDTO
    {
        return new DomainDTO(
            $this->get('url'),
            $this->get('productID'),
        );
    }
}
