<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    public $timestamps = false;
    protected $fillable = ['type_depense', 'budget', 'annee'];
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($depense) {
            $depense->reference = strtoupper(substr($depense->type_depense, 0, 3));
        });
    }
}
