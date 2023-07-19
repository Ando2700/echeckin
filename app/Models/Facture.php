<?php

namespace App\Models;

use App\Models\Acte;
use App\Models\Patient;
use App\Models\Detailfacture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Facture extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function patient(){
        return $this->belongsTo(Patient::class);
    }

    public function detailfactures(){
        return $this->hasMany(Detailfacture::class);
    }
    
}
