<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'amount',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
