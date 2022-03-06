<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function patients()
    {
        return $this->belongsTo(User::class,'patient_id');
    }

    public function doctors()
    {
        return $this->belongsTo(User::class,'doctor_id');
    }
}
