<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModulePermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'name' ,
        'title',
        'status',
    ];

    protected function permissions()
    {
        return $this->hasOne(Permission::class);
    }
}
