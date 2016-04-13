<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Repositories\UsersRepository;

class UsersController extends Controller
{
	protected $users;

	public function __construct(UsersRepository $users) {
		$this->middleware('auth');
		$this->users = $users;
	}

    public function index() {
    	return view('users.index');
    }

    // TODO fazer algum tratamento do request
    public function editUsername(Request $request) {
    	// TODO fazer algum tratamento de permissões
    	$this->users->changeName($request->user()->id, $request->username);
    	return view('home');
    }
}
