<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = ['code', 'description', 'discount_amount', 'is_active'];
}
