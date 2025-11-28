<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class MedicalRecord extends Model
{
    use HasFactory, Auditable;
    protected $fillable = [
        'patient_id', 'doctor_id', 'diagnosis', 'treatment', 'prescription', 'visit_date',
        'soap_data',
        'vital_signs',
        'attachments',
        'icd10_code',
        'icd10_name',
        'icd9_code',
        'icd9_name',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'soap_data' => 'array',
        'vital_signs' => 'array',
        'attachments' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function prescriptionItems()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function labResults()
    {
        return $this->hasMany(LabResult::class);
    }
}
