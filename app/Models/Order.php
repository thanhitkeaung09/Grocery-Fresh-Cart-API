<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ["name","phone_number","address","product_id"];

//    protected $with = ['product'];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function photo(){
        return $this->belongsTo(Photo::class);
    }
}
