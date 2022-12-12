<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        "product","price","stock"
    ];

    protected $with = ['photos'];


    public function photos(){
        return $this->hasMany(Photo::class);
    }

//    public function product(){
//        return $this->belongsTo(Order::class);
//    }

}
