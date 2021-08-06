<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    
    /**
     * Order products
     * @var array
     */
    public $products = array();
    
    protected $fillable = ["clientName", "status"];
}
