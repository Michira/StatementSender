<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    public function products(){
    	return $this->hasManyThrough('App\Product', 'App\ClientProduct', 'client_id','id');
    }
}
