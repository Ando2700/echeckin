<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charge extends Model
{
    public $timestamps = false;
    use HasFactory;
    public function getDateAttribute()
    {
        return sprintf('%02d-%02d-%04d', $this->jour, $this->mois, $this->annee);
    }
}
