<?php

namespace Raffles\Modules\Poga\Models\Traits;

trait UserTrait
{
    /**
     * Set the user's password.
     *
     * @param  string $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        if ('' !== $value) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
}
