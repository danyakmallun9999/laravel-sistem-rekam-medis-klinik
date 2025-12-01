<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Doctor extends Model
{
    use HasFactory, Auditable;
    protected $fillable = ['name', 'specialization', 'phone', 'email', 'consultation_fee'];

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
