<?php

namespace App;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    public function question(){
    	return $this->belongsTo(Question:class);
    }
    public function user(){
    	return $this->belongsTo(User:class);
    }
}
