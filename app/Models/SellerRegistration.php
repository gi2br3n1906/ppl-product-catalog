<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_toko',
        'deskripsi_singkat',
        'nama_pic',
        'no_hp_pic',
        'email_pic',
        'jalan',
        'rt',
        'rw',
        'kelurahan',
        'kab_kota',
        'provinsi',
        'no_ktp_pic',
        'foto_pic',
        'file_ktp',
        'password',
        'status',
        'rejection_reason',
        'verified_at',
        'verified_by',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
