<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlternativeCriteria extends Model
{
    Protected $table = 'alternative_criteria';

    public function criteria()
    {
    	return $this->belongsTo('App\Criteria');
    }

    public function alternative()
    {
    	return $this->belongsTo('App\Alternative');
    }
}
