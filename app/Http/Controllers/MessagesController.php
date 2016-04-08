<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Repositories\MessagesRepository;
use App\Topic;
use App\Message;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AddMessageRequest;

class MessagesController extends Controller {
	protected $messages;

	public function __construct(MessagesRepository $messages) {
		$this->middleware('auth');
		$this->messages = $messages;
	}

    public function store(AddMessageRequest $request, $topic_id) {
    	$this->messages->storeMessage($request->user(), $topic_id, $request->message);
    	$destination = 'topic/' . $topic_id;
        return view('home');
    	//return Redirect::to('topic/' . $topic->id);
    }

    public function destroy(Topic $topic, Message $message) {
    	$this->authorize('destroy', $message);
    	$this->messages->destroy($message);
        return view('home');
    	//return Redirect::to('topic/' . $topic->id);
    }

    public function viewMessage($topic_id, $message_id) {
        $data['title'] = $this->messages->getMessageFromTopic($topic_id, $message_id);
        return view('messages.editForm', ['message_title' => $data['title']]);
    }

    // TODO fazer verificacao do request (conteudo nao pode ser vazio)
    public function update(Request $request, $topic_id, $message_id) {
        $this->messages->updateContent($message_id, $topic_id, $request->message);
        return view('home');
        //return Redirect::to('topic/' . $topic_id);
    }
}
