<?php

namespace App\Rules;

use App\Enums\StatusEnum;
use Closure;
use Illuminate\Contracts\Validation\Rule;

class SellingRule implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return in_array(strtolower($value), [StatusEnum::DEBT->value, StatusEnum::CASH->value, StatusEnum::SPLIT->value]);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Status Pembayaran tidak valid';
    }
}
