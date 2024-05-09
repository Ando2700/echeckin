<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Attendee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $casts = ['status' => 'integer'];
    protected $fillable = ['qr_code', 'status', 'evendetail_id', 'attendee_id', 'reference'];

    public function event(){
        return $this->belongsTo(Event::class, 'eventdetail_id');
    }

    public function attendee(){
        return $this->belongsTo(Attendee::class, 'attendee_id');
    }
}
