<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Customer extends Model
{
    use HasFactory;
    protected $fillable = [
        'kontrak_no',
        'client_name',
        'otr',
        'dp',
        'pokok_utang',
        'jangka_waktu',
        'bunga',
        'date',
    ];

    public function tenor()
    {
        return $this->hasMany(Tenor::class, 'customer_id');
    }
}
