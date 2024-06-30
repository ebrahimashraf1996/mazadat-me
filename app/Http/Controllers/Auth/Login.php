<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{

    public function selection()
    {
      return view('auth.selection');
    }
  
    public function login($type)
    {
      return view('auth.login',get_defined_vars());
    }

    public function login_auth(Request $request)
    {
        $credentials = request(['email', 'password']);

        if(Auth::guard($request->type)->attempt($credentials))
        {
          return redirect()->intended(route('admin.dashboard'));
        }else{
            alert()->error('بيانات الدخول ليست صحيحة');
            return back();
        }
        
    }

    public function logout()
    {
      auth()->guard('admin')->logout();
      return redirect()->route('selection');
    }

    public function logoutAuction()
    {
      auth()->guard('auction')->logout();
      return redirect()->route('selection');
    }

    public function logoutDelivery(){
      auth()->guard('delivery')->logout();
      return redirect()->route('selection');
    }

}
