<?php

namespace App;
use App\Answer;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
	protected $fillable = ['title', 'body'];

    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function answers(){
    	return $this->hasMany(Answer::class);
    }
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
}