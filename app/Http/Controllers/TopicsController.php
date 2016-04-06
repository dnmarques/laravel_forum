<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Repositories\TopicsRepository;
use App\Topic;
use App\Http\Requests\AddTopicRequest;
use Redirect;

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
        return view('topics.index', ['topics' => $this->topics->allWithUser()]);
    }

    public function showTopicMessages(Topic $topic) {
        $data['topic_title'] = $topic->title;
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
