<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'size';
    protected $fillable = [
        'name',
    ];
}