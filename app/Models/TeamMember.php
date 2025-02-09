<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class TeamMember extends Model implements TranslatableContract
{
	use Translatable;
	protected $table = 'team_members';
	public $translatedAttributes = ['name','title','alt'];
}
