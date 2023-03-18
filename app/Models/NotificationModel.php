<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CalculationFormulaDetailModel;

class NotificationModel extends Model
{

    public $table         = 'notifications';
    protected $primaryKey = 'id';
    public $timestamps    = true;


    public function getAll()
    {
        $data = $this->all();
        return $data->toArray();
    }


}
