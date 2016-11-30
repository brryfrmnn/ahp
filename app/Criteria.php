<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    Protected $fillable = ['name'];

    public function user()
    {
    	return $this->belongsTo('App\User');
    }
}
