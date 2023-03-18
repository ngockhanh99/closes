<?php

namespace App\Models\Dochoi;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanphamFile extends Model
{
    protected $table = 'dochoi_san_pham_file';
    public $timestamps    = FALSE;
    protected $fillable = [
        'media_id',
        'dochoi_san_pham_id',
    ];
}