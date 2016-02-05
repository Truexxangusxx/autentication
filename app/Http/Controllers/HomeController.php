<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use App\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }
    
    public function validar(Request $request)
    {
        
        $name=$request->name;
        $password=$request->password;
        /*
        if (Auth::attempt(array('name' => $name, 'password' => $password)))
        {
            $valido=true;
        }
        else{
            $valido=false;
        }
        */
        return "aaaaaaaaaaaaaaaaaaaaaaa";
        //return $valido ? "si": "no";
    }
    
    public function metodo(){
        return "funciona ps basura";
    }
}
