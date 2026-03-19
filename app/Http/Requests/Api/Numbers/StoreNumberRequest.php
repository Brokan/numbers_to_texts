<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Numbers;

use App\Http\Requests\Api\ApiRequest;

/**
 * @property int $number
 */
class StoreNumberRequest extends ApiRequest
{
    /**
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'number' => ['required', 'integer', 'min:0'],
        ];
    }

    #[\Override]
    public function messages(): array
    {
        return [
            'number.required' => 'Number is required',
            'number.integer' => 'Number must be an integer',
            'number.min' => 'Number must be >= 0',
        ];
    }
}
