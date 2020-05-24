<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillStatus extends Model
{
    protected $table = "bill_status";

    public function bill(){
    	return $this->hasMany('App\Bill','status_id','id');
    }
}
