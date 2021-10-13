<?php

namespace App\Http\Controllers\Auth;

use session;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController extends Controller
{

    /**
     * login
     *
     * @param  mixed $request
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'login_email' => 'required|email',
            'login_password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->login_email, 'password' => $request->login_password])) {
            return redirect('/dashboard');
        }
        // session::flash('unsuccess', 'Your email address or password is incorrect!');
        return Redirect::back()->with('unsuccess', 'Your email address or password is incorrect!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home');
    }
}
