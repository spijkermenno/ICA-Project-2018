<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use LVR\CreditCard\ExpirationDateValidator;
use LVR\CreditCard\CardExpirationDate as LVRCardExpirationDate;

class CardExpirationDate extends LVRCardExpirationDate
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try {
            $date = Carbon::createFromFormat($this->format, $value);

            return (new ExpirationDateValidator($date->year, $date->month))
                ->isValid();
        } catch (\InvalidArgumentException $ex) {
            $this->message = static::MSG_CARD_EXPIRATION_DATE_FORMAT_INVALID;

            return false;
        } catch (\Exception $ex) {
            $this->message = static::MSG_CARD_EXPIRATION_DATE_INVALID;

            return false;
        }

        return false;
    }
}
