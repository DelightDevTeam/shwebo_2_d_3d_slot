<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'digit', 'image','bank_account_name', 'bank_account_no', 'agent_id'];
    
    protected $appends = ['img_url'];

    public function getImgUrlAttribute()
    {
        return asset('assets/img/banks/'.$this->image);
    }

    public function agent()
    {
        return $this->belongsToMany(User::class);
    }
}
