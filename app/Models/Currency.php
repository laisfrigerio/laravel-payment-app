<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $primaryKey = "iso";
    
    public $incrementing = false;

    protected $fillable = [
        "iso"
    ];
}
