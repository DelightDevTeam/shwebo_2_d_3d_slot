<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentType extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $fillable = ['name'];
=======
    protected $fillable = [ 'name' ];

    public function paymentImages()
    {
        return $this->hasMany(PaymentImage::class, 'payment_type_id');
    }
>>>>>>> 35c56e94e1fe85ce69663e6d5858cbd013d662fb
}
