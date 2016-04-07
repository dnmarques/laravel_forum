<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\MessagesRepository;
use App\Topic;
use Illuminate\Support\Facades\Redirect;

class MessagesController extends Controller {
	protected $messages;

	public function __construct(MessagesRepository $messages) {
		$this->middleware('auth');
		$this->messages = $messages;
	}

    public function store(Requests\AddMessageRequest $request, Topic $topic) {
    	$this->messages->storeMessage($request->user(), $topic, $request->message);
    	$destination = 'topic/' . $topic->id;
    	return Redirect::to('topic/' . $topic->id);
    }
}