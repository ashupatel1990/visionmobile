<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchase;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';
    protected $guarded = [];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'stock_id', 'id');
    }
}
