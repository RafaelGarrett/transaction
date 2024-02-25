<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;
    protected $table='status';
    protected $fillable=['description'];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
