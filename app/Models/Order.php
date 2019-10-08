<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = "id";
    
    public $incrementing = false;
    
    protected $fillable = [
        "id", "payment_platform_id", "value", "approval_link", "currency_id"
    ];
}
