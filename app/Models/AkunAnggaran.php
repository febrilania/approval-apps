<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkunAnggaran extends Model
{
    use HasFactory;
    protected $table = 'akun_anggaran';
    protected $fillable = [
        'nama_akun'
    ];

    public function purchase_requests_detail()
    {
        return $this->hasMany(PurchaseRequestDetail::class, 'akun_anggaran_id');
    }
}
