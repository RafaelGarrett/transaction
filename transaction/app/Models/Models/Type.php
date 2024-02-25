<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\User;

class Type extends Model
{
    use HasFactory;
    protected $table='types';
    protected $fillable=['description'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
