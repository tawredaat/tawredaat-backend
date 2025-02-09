<?php

namespace App\Rules;

use App\Helpers\General;
use App\Models\ShopProduct;
use Illuminate\Contracts\Validation\Rule;

class ValidCartItemQuantity implements Rule
{

    protected $productId;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($productId)
    {
        $this->productId=$productId;
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
        $product=ShopProduct::find($this->productId);
        if($product){
            if(in_array($value,General::CreateProductInterval(1,$product->qty,1)))
                return true;
            return false;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid Quantity';
    }
}
