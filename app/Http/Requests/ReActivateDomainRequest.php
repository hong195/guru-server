<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class ReActivateDomainRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['old_domain' => "string[]", 'new_domain' => "string[]"])] public function rules(): array
    {
        return [
            'old_domain' => ['required', 'string'],
            'new_domain' => ['required', 'string'],
        ];
    }
}
