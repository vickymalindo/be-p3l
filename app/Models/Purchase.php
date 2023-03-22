<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'user_address',
      'user_fullname',
      'payment',
      'total_price',
      'delivered',
      'list_product',
      'user_phone',
    ];

     protected $casts = [
      'total_price' => 'integer'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
