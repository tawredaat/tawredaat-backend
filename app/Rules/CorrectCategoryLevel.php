<?php

namespace App\Rules;

use App\Models\Category;
use Illuminate\Contracts\Validation\Rule;

class CorrectCategoryLevel implements Rule
{

    public $in_category;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($in_category)
    {
        $this->in_category = $in_category;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return !is_null(Category::where('id', $this->in_category)
                ->where('level', $value)->first());
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.category_level_does_no_match_in_category_id');

    }
}
