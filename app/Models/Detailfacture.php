<?php

namespace App\Models;

use App\Models\Acte;
use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Detailfacture extends Model
{
    public $timestamps = false;
    protected $fillable = [];
    use HasFactory;
    public function facture(){
        return $this->belongsTo(Facture::class);
    }
    public function acte(){
        return $this->belongsTo(Acte::class);
    }
}
