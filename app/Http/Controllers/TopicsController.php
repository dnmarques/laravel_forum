<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\TopicsRepository;
use App\Topic;
use App\Http\Requests\AddTopicRequest;
use Illuminate\Support\Facades\Cache;
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
        /*$topics = Cache::tags(['topics'])->remember('topics.index', 2, function() {
            return $this->topics->allWithUser();
        });*/
        return view('topics.index', ['topics' => $topics]);
    }
    
    /**
     * Shows the messages of the topic
     * @param  Topic  $topic [description]
     * @return [type]        [description]
     */
    public function showTopicMessages(Topic $topic) {
        $data['topic_title'] = $topic->title;
        
        /*$key = 'messages-' . $topic->id;
        $data['messages'] = Cache::remember($key, 2, function() use ($topic) {
            return $this->topics->getAllMessagesFromTopic($topic);
        });*/
        
        $data['messages'] = $this->topics->getAllMessagesFromTopic($topic);
        return view('topics.messages', $data);
    }
    
    public function showTopicForm() {
        return view('topics.form');
    }

    public function store(AddTopicRequest $request) {
        $this->topics->create($request->user(), $request->title);
        return Redirect::to('topics');
    }

    public function destroy(Topic $topic) {
        $this->authorize('destroy', $topic);
        $this->topics->destroy($topic);
        return Redirect::to('topics');
    }
}
