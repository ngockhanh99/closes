<?php
namespace App\Models\Dochoi;

use App\Models\Cores\Cores_Media;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
    public $timestamps    = TRUE;
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'province_id',
        'district_id',
        'village_id',
        'address',
        'payment',

    ];
    public function orderDraft(){
        return $this->hasMany(OrderDraft::class,'id','order_id');
    }
}