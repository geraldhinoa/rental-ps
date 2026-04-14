<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'inventory_id', 'pricing_package_id', 'start_time', 'end_time', 'total_price', 'status'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }

    public function pricingPackage()
    {
        return $this->belongsTo(PricingPackage::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
