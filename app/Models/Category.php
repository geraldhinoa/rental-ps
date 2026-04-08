<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }

    public function pricingPackages()
    {
        return $this->hasMany(PricingPackage::class);
    }
}
