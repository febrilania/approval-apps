<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_request_id',
        'approver_id',
        'stage',
        'is_approved',
        'approved_at',
        'is_current_stage'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    public function purchase_request()
    {
        return $this->belongsTo(PurchaseRequest::class);
    }
}
