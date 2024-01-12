<?php

namespace App\Models;

use App\Models\Place;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;
    protected $fillable = ['path', 'place_id'];
    public $timestamps = false;

    public function place()
    {
        return $this->belongsTo(Place::class);
    }
}
