<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Dashboard extends Model
{
    protected $table = 'dochoi_dashboard';
    protected $fillable = [
        'address',
        'phone',
        'email',
        'facebook',
        'zalo',
        'instagram'
    ];
}