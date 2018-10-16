<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    # 用户-问题
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    # 用户-问题
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    /*  --------------- 关注 ---------------- */
    # 多态方法
    public function follow()
    {
        return $this->morphMany('App\Follower','followerable');
    }

    //关注用户数量统计 用来判断是否1已关注对象
    public function followed($id)
    {
        return $this->follows()->where('followerable_id',$id)->count();
    }

    # 一个用户有多个粉丝 每个粉丝有多个粉丝

    //用户粉丝
    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','followerable_id','user_id')->where('followerable_type',self::class)->withTimestamps();
    }

    # 用户关注
    public function follows()
    {
        return $this->belongsToMany(self::class,'followers','user_id','followerable_id')->where('followerable_type',self::class)->withTimestamps();
    }
}
