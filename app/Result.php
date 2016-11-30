<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    Protected $fillable = ['alternative_id'];

    public function alternative()
    {
    	return $this->hasOne('App\Alternative','id','alternative_id');
    }
}
