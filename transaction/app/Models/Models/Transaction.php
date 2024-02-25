<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Transaction extends Model
{
    use HasFactory;
    protected $table='transactions';
    protected $fillable=['amount','origin_user','destination_user','status_id'];

    public function status(): HasOne
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function relUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'origin_user');
    }

}
