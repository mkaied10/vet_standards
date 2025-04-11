<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $fillable = ['subcategory_id', 'title', 'content', 'file_path'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}