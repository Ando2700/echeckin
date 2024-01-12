<?php

namespace App\Models;

use App\Models\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model
{
    use HasFactory;
    protected $fillable = ['nomplace', 'numberplace', 'description', 'price', 'address'];
    public $timestamps = false;
    public function images(){
        return $this->hasMany(Image::class);
    }
}
