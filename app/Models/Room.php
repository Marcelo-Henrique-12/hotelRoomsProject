<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $table ="rooms";

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }
    use HasFactory;

    protected $fillable =[
        'name',
        'description',
        'hotel_id',
    ];
}
