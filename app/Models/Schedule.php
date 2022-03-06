<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from',
        'to'
    ];

    public function users()
    {
        return $this->belongsTo(User::class,'user_id');
    }


}
