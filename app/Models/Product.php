<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'quantity', 'price', 'warehouse_id'];


    public function  warehouses(){
        return $this->belongsTo(Warehouse::class);
    }
}
