<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name'];
    protected $fillable=['name','section_id'];
    protected $table = 'products';
    public $timestamps = true;

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

}
