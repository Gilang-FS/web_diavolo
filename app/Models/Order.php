<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id','order_number','subtotal','shipping_cost',
        'total','status','recipient_name','phone',
        'address','city','province','postal_code','notes'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public static function generateOrderNumber(): string
    {
        return 'DVL-' . strtoupper(uniqid());
    }
}