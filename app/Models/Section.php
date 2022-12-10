<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Section extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name'];
    protected $fillable=['name','notes'];
    protected $table = 'sections';
    public $timestamps = true;

    public function product()
    {
        return $this->hasMany(Product::class);
    }

    public function invoice()
    {
        return $this->hasMany(Invoice::class);
    }
}
