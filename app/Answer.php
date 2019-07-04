<?php

namespace App;

use App\Question;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['body', 'user_id'];


    public function question(){
    	return $this->belongsTo(Question::class);
    }
    public function user(){
    	return $this->belongsTo(User::class);
    }
    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }
    public static function boot()
    {
        parent::boot();
        static::created(function ($answer) {
            $answer->question->increment('answers_count');
        });
        static::deleted(function ($answer) {

            if ($answer->question->answers_count > 0) {
                $answer->question->decrement('answers_count');
            }
            $question = $answer->question;
            if ($question->best_answer_id === $answer->id) {
                $question->best_answer_id = NULL;
                $question->save();
            }
        });
    }
    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans(); //criado à um mês/um ano ou o que seja
    }
    public function getStatusAttribute()
    {
        return $this->id === $this->question->best_answer_id ? 'vote-accepted' : '';
        return $this->isBest() ? 'vote-accepted' : '';
    }
     public function getIsBestAttribute()
     {
        return $this->isBest();
     }
     public function isBest()
     {
        return $this->id === $this->question->best_answer_id;
     }


}
