<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;


class Blog extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['title','alt','description','description_meta','tags','tags_meta','slug','page_title','meta_title'];


    public function filtertags(){
$query = Blog::query();


        return $query->whereHas('translations', function ($query)  {
foreach (explode(',', $this->tags) as $tag){
    $query->orWhere('tags', 'like', '%' . $tag . '%');
}

        })->where('id','!=',$this->id)->limit(4)->get();


    }


}
