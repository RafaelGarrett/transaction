<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class Account extends Model
{
    use HasFactory;
    protected $table='accounts';
    protected $fillable=['balance','user_id'];

    public function relUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
