<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\InvoiceItem;

class Invoice extends Model
{
    protected $fillable = [
        'patient_id',
        'appointment_id',
        'invoice_number',
        'total_amount',
        'status',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
