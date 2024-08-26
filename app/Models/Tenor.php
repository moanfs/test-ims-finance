<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenor extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'angsuran_ke',
        'angsuran_per_bulan',
        'tanggal_jatuh_tempo',
        'total_pembayaran',
        'denda',
        'telat',
        'status_pembayaran',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
