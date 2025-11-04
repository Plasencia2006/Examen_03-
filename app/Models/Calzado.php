<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calzado extends Model
{
    use HasFactory;

    protected $fillable = ['modelo', 'talla', 'color', 'precio', 'marca_id', 'imagen'];


    public function marca()
    {
        return $this->belongsTo(Marca::class);
    }
}
