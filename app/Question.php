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
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
    public function getUrlAttribute()
    {
        return route("questions.show", $this->slug);
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans(); //criado à um mês/um ano ou o que seja
    }
    public function getStatusAttribute()
    {
        if ($this->answers_count > 0) {
            if ($this->best_answer_id) {
                return "answered-accepted";
            }
            return "answered";
        }
        return "unanswered";
    }
    public function getBodyHtmlAttribute(){
        return \Parsedown::instance()->text($this->body);
    }
    public function answers(){
    	return $this->hasMany(Answer::class)->orderBy('votes_count', 'DESC');;
    }

    public function getExcerptAttribute()
    {
        return $this->excerpt(250);
    }
    public function excerpt($length)
    {
        return str_limit(strip_tags($this->bodyHtml()), $length);
    }

    private function bodyHtml()
    {
        return \Parsedown::instance()->text($this->body);
    }

}