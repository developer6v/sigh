<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagnosis extends Model
{
    protected $fillable = ['appointment_id','icd_code','description'];

    public function appointment() { return $this->belongsTo(Appointment::class); }
}
