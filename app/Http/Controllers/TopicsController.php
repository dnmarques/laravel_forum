<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\TopicsRepository;
use App\Topic;
use App\Http\Requests\AddTopicRequest;
use Illuminate\Support\Facades\Redirect;

class TopicsController extends Controller
{
    protected $topics;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(TopicsRepository $topics) {
        $this->middleware('auth');
        $this->topics = $topics;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $topics = $this->topics->allWithUser();
        return view('topics.index', ['topics' => $topics]);
    }
    
    /**
     * Shows the messages of the topic
     * @param  Topic  $topic [description]
     * @return [type]        [description]
     */
    public function showTopicMessages($topic_id) {
        $data['topic_title'] = $this->topics->getTopicTitle($topic_id);
        $data['messages'] = $this->topics->getAllMessagesFromTopic($topic_id);
        return view('topics.messages', $data);
    }
    
    public function showTopicForm() {
        return view('topics.form');
    }

    public function store(AddTopicRequest $request) {
        $topic = $this->topics->create($request->user(), $request->title);
        return view('home');
        //return Redirect::to('topics');
    }

    public function destroy(Topic $topic) {
        $this->authorize('destroy', $topic);
        $this->topics->destroy($topic);
        return view('home');
        //return Redirect::to('topics');
    }
}
