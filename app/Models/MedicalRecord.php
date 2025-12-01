<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class MedicalRecord extends Model
{
    use HasFactory, Auditable;
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'appointment_id',
        'diagnosis',
        'treatment',
        'prescription',
        'visit_date',
        'soap_data',
        'vital_signs', // Keeping this as it was in the original, and the instruction's partial list also includes it.
        'systolic',
        'diastolic',
        'heart_rate',
        'temperature',
        'weight',
        'height',
        'clinical_analysis',
        'attachments',
        'icd10_code',
        'icd10_name',
        'icd9_code',
        'icd9_name',
        'body_map_data',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'soap_data' => 'array',
        'vital_signs' => 'array',
        'clinical_analysis' => 'array',
        'attachments' => 'array',
        'body_map_data' => 'array',
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

    /**
     * Check if this medical record is the latest one for the patient.
     *
     * @return bool
     */
    public function isLatestForPatient()
    {
        $latestRecord = self::where('patient_id', $this->patient_id)
            ->latest('created_at')
            ->first();

        return $latestRecord && $latestRecord->id === $this->id;
    }
}
