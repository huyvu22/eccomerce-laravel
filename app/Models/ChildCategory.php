<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    use HasFactory;
    protected $table= 'child_categories';

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
