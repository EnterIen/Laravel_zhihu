<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AnswerRequest;
use App\Answer;
use Auth;

class AnswerController extends Controller
{
    public function store(AnswerRequest $AnswerRequest,$questionId)
    {
    	Answer::UpdateOrCreate(
    		['question_id' => $questionId,
    		 'user_id' => Auth::id()],
    		['content' => $AnswerRequest->get('content')]
    		);
    	return back();
    }
}