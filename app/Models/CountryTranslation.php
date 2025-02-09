<?php
namespace App\Models;

class CountryTranslation extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = true;

    protected $table = 'country_translations';
    public $timestamps = false;
}
