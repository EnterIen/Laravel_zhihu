<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\QuestionRequest;
use Auth;
use App\Label;
use App\Question;

class QuestionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::orderBy('created_at','desc')->paginate(20);
        return view('question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('question.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
         //标签新增
        $labelIds = Label::upsert($request->get('labels'));

        //问题新增
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
            'user_id' => Auth::id(),
        ];
        $question = Question::create($data);
        //关系新增
        $question->labels()->attach($labelIds);
        
        return redirect()->route('question.show', [$question->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $question = Question::find($id);
    
        return view('question.show',compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $question = Question::find($id);

        return $question->user_id == Auth::id() ? view('question.edit',compact('question')) : abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $question = Question::find($id);
         //标签新增
        $labels = Label::upsert($request->get('labels'));

        //问题新增
        $data = [
            'title' => $request->get('title'),
            'description' => $request->get('description'),
        ];
        $question->update($data);

        $question->labels()->sync($labels);

        return redirect()->route('question.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
