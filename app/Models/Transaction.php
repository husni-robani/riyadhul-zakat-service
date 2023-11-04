<?php

namespace App\Models;

use App\Enum\DonationType;
use App\Enum\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'donors_id',
        'donation_type',
        'payment_method',
        'total_money',
        'total_good',
        'status'
    ];

    protected $casts = [
    ];

    public function donor(): BelongsTo
    {
        return $this->belongsTo(Donor::class, 'donors_id', 'id');
    }
}
