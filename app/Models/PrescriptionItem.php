<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\MedicalRecord;
use App\Models\Medicine;

class PrescriptionItem extends Model
{
    protected $fillable = ['medical_record_id', 'medicine_id', 'quantity', 'instructions'];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}
