<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function paymentImages()
    {
        return $this->hasMany(PaymentImage::class, 'payment_type_id');
    }
}
