<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_name',
        'category_id',
        'description',
        'unit_price',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Item::class, 'category_id');
    }

    public function purchase_requests_detail()
    {
        return $this->hasMany(PurchaseRequestDetail::class, 'item_id');
    }
}
