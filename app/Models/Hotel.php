<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $table ="hotels";
    use HasFactory;

    protected $fillable =[
        'name',
        'zip_code',
        'address',
        'city',
        'state',
        'website',
    ];
}
