<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Search by keywords
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $nickname)
    {
        $user = new User();
        $user_detail = $user->getUser($nickname);
        return view('user', [
            'user' => $user_detail,
        ]);
    }
}
