<?php

namespace App\Models;

use App\Models\Place;
use App\Models\Eventtype;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['eventname', 'datedebut', 'datefin', 'description', 'place_id', 'eventtype_id'];
    public function place(){
        return $this->belongsTo(Place::class, 'place_id');
    }
    public function eventtype(){
        return $this->belongsTo(Eventtype::class, 'eventtype_id');
    }
}
