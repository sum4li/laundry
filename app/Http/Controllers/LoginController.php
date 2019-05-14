<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;



class LoginController extends Controller
{

    use AuthenticatesUsers;

    protected $redirectTo = '/dashboard';

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        return view('backend.component.login');
    }

    public function dashboard(){
        return view('backend.dashboard.index');
    }

}
