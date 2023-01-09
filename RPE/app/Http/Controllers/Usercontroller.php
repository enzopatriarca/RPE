<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;

class Usercontroller extends Controller{

    public function index(){

    	return view('loggin');
    }

    public function authenticate($pass){
        Auth::logoutOtherDevices($pass);

    }

  

    public function login(Request $request){


        $this->validate($request,[
            'username' => 'required',
            'password' => 'required'
        ],[
            'username.required' => 'Username é obrigatorio!',
            'password.required' => 'Senha é obrigatoria!',
        ]);

        $user = ($request->username);
        $pass  = $request->password;

        //dd($user);
        //dd($pass);

        
        if (auth()->attempt(array('name' => $user, 'password' => $pass))){
            //$this->authenticate($pass);
            
            //dd('logou');
            Auth::logoutOtherDevices($pass);

            $request->session()->flash('flash_notification.success', 'Voce esta logado!');
            return redirect('/dashboard');                             
            //echo "Falha";
            //dd('aqui');
        }
        else{  
             
            return redirect()->back()->withInput($request->input())->with('danger', 'Username ou senha invalidos');
        }

    }

    public function check_login(){
        if (Auth::check()){
    
        }

    }

    public function logout(){
        Auth::logout();
        return redirect('/');

    }
    
}
