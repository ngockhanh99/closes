<?php
/**
 * @license Apache 2.0
 */

namespace App\Models\Cores;

/**
 *
 * @OA\Schema(
 *     schema="User",
 *     title="User model",
 *     description="Lưu trữ và quản lý người sử dụng",
 * )
 */

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cores_user_client extends Model
{
    protected $primaryKey = 'id';
    public    $timestamps = TRUE;
    protected $table      = 'user_client';
    protected $fillable = [
        'email',
        'password',
        'remember_token',
    ];
    static function makeInstance()
    {
        return new self();
    }
}