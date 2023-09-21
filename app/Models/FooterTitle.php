<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterTitle extends Model
{
    use HasFactory;
    protected $table = 'footer_titles';
    protected $fillable = [
        'footer_column_2_title,
        footer_column_3_title'
    ];
}
