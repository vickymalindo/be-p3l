<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    use HasFactory;

    protected $fillable = [
      'user_id',
      'product_code',
      'product_name',
      'product_image',
      'product_price',
    ];

    protected $casts = [
      'product_price' => 'integer'
    ];

    public function user()
    {
      return $this->belongsTo(User::class);
    }
}
