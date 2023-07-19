<?php

namespace App\Models;

use App\Models\Facture;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Acte extends Model
{
    public $timestamps = false;
    protected $fillable = ['type_acte', 'budget', 'annee'];
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($acte) {
            $acte->reference = strtoupper(substr($acte->type_acte, 0, 3));
        });
    }

    public function detailfactures(){
        return $this->hasMany(DetailFacture::class);
    }


}
