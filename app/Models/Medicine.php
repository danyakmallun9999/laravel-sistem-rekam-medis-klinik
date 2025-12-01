<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Auditable;

class Medicine extends Model
{
    use Auditable;
    protected $fillable = ['name', 'stock', 'min_stock', 'batch_number', 'expired_date', 'price'];

    protected $casts = [
        'expired_date' => 'date',
    ];
}
