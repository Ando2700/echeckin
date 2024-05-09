<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eventdetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = ['additional_information', 'event_id'];
}
