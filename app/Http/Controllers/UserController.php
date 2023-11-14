<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function registerForm(){
        if(auth()->check()){
            return redirect('');
        }
        return view('auth.register');
    }
    public function loginForm(){
        if(auth()->check()){
            return redirect('/');
        }
        return view('auth.login');
    }
    public function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'password'=> 'required'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        auth()->login($user);
        return redirect('/');
    }
    public function auth(Request $request){
        if(auth()->attempt([
            'email'=>$request->email,
            'password'=>$request->password
        ])){
            return redirect('/');
        }else{
            return redirect('/login')->with([
                'error' =>'those are wrong'
            ]);
        }
    }
    public function logout(){
        auth()->logout();
        return redirect('/');
    }

    public function follow($following_id){

        $following = User::find($following_id);
        if(auth()->user()->followings->contains($following->id)){
            auth()->user()->followings()->detach($following);
        }else{
            auth()->user()->followings()->attach($following);
        }     
        return redirect('/');
    }

}
