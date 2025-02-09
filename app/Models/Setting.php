<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Setting extends Model implements TranslatableContract
{
    use Translatable;
    public $translatedAttributes = ['footerLogoAlt', 'siteLogoAlt', 'description', 'address', 'title', 'Meta_Description', 'keywords', 'logo', 'site_logo', 'footer_logo','rfq_image','rfq_banner'];
}
