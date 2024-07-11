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
        try{
            $counting_data = count($value);
            $counting_true = 0;
            foreach($value as $item) {
                if(in_array(strtolower($item), [StatusEnum::DEBT->value, StatusEnum::CASH->value, StatusEnum::SPLIT->value])) $counting_true += 1;
            }
            
            return $counting_data == $counting_true;
        }catch(\Throwable $th){
            return in_array(strtolower($value), [StatusEnum::DEBT->value, StatusEnum::CASH->value, StatusEnum::SPLIT->value]);
        }
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
