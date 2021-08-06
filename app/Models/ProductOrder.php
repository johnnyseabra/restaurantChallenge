<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $table = 'products_orders';
    
    protected $fillable = ["product", "order", "quantity"];

}
