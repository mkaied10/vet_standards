<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $table = 'sub_categories';
    protected $fillable = ['category_id', 'name', 'image'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}