<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'vendor_id',
        'total',
        'status'
    ];
    // Customer relationship
    public function user() // you called it 'customer' in controller
    {
        return $this->belongsTo(User::class);
    }
    
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function customer()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    // Scopes for status
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }
}
