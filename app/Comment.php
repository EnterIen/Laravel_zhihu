<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
     protected $fillable = ['user_id','content','parent_id','commentable_type','commentable_id'];

     # 用户-评论呢
     public function user()
	{
	    return $this->belongsTo(User::class);
	}
	
	public function commentable()
	{
	    return $this->morphTo();
	}
}
