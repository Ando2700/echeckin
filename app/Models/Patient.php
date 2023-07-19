<?php

namespace App\Models;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patient extends Model
{
    protected $fillable = ['nom', 'date_naissance', 'genre', 'remboursement'];
    public $timestamps = false;
    use HasFactory;

    public function factures(){
        return $this->hasMany(Facture::class);
    }
}
