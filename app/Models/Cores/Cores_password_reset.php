<?php

namespace App\Models\Cores;

use Illuminate\Database\Eloquent\Model;

class Cores_password_reset extends Model
{
    protected $primaryKey = 'id';
    public    $timestamps = FALSE;
    protected $table      = 'cores_password_resets';
    protected $fillable = [
        'email',
        'token',
    ];
}
