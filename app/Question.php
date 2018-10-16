<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title','description','user_id'];

    //问题->标签
	public function labels()
	{
	    return $this->belongsToMany(Label::class)->withTimestamps();
	}

	public function answers()
	{
	    return $this->hasMany(Answer::class);
	}


	# 问题-答案
	public function answer()
	{
	    return $this->hasOne(Answer::class);
	}

	# 问题-用户
	public function user()
	{
	    return $this->belongsTo(User::class);
	}

	public function follow()
{
    return $this->morphMany('App\Follower','followerable');
}
}


