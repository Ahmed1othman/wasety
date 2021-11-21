<?php

namespace App\Rules;

use App\Models\Auction;
use App\Models\Project;
use App\Models\User;
use Illuminate\Contracts\Validation\Rule;

class RateExists implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public $type;

    public function __construct($param = "user")
    {
        $this->type = $param;
    }


    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (strtolower($this->type) == "user") {
            return User::find($value) ? true : false;
        }  elseif (strtolower($this->type) == "project") {
            return Project::find($value) ? true : false;
        } {
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute is Not exists in Model';
    }
}
