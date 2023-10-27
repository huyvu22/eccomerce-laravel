<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VnPaySetting extends Model
{
    use HasFactory;
    protected $table = 'vn_pay_settings';

    protected $fillable = [
        'status',
        'name',
        'mode',
        'country_name',
        'currency_name',
        'currency_rate',
        'client_id',
        'secret_key',
    ];
}
