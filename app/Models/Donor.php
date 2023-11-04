<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Donor extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['name', 'house_number', 'total_muzaki', 'email', 'phone'];

    protected $table = 'donors';

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'donors_id', 'id');
    }
}
