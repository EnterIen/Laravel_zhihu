<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Comment;
use App\Answer;
use App\Question;
use Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function answer($id)
	{
	    $data = ['commentable_id'=>$id,'commentable_type'=>'App\Answer'];
	    $comments = Comment::where($data)->get();
	    return view('comment.show',compact('comments'),$data);
	}

	public function store(CommentRequest $request)
	{
	    $condition = [
	        'user_id' => Auth::id(),
	        'commentable_type' => $request->get('commentable_type'),
	        'commentable_id' => $request->get('commentable_id'),
	        'parent_id' => $request->get('parent_id'),
	    ];
	    $data = [
	        'parent_id' => $request->get('parent_id'),
	        'content' => $request->get('content'),
	    ];
	    Comment::updateOrCreate($condition,$data);
	    return back();
	}
}