<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\historico;

class SesionController extends Controller
{
    public function metodo(Request $request){
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
        $email=$request->email;
        $password=$request->password;
        
        if (Auth::attempt(array('email' => $email, 'password' => $password)))
        {
            $valido=User::where('email',[$email])->get();
            Session::put('usuario', User::where('email',[$email])->get());
        }
        else{
            $valido=null;
        }
        
        return $valido;
    }
    
    public function registrar(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
        $email=$request->email;
        $password=$request->password;
        $name=$request->name;
        $msg="";
        $error=false;
        
        $valido=User::where('email',[$email])->count();

        if ($valido == 0){
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => bcrypt($password),
            ]);
            $msg="Usuario registrado correctamente";
        }
        else{
            $user=$valido;
            $msg="El correo ya ha sido registrado";
            $error=true;
        }

            
        return ["user"=>$user, "msg"=>$msg, "error"=>$error];
        
    }
    
    public function obtener_sesion(Request $request){
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
        return Session::get('usuario');
    }
    
    public function enviar_email(Request $request){
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
            $msg=$request->msg;
            $email=$request->email;
            $name=$request->name;
            
            $data = array(
                'msg' => $msg,
                'name' => $name,
                'email' => $email,
            );
            
            
            
            $email = explode(";", trim($email));
            Mail::send('mails.test', $data, function ($message) use ($name,$email,$name) {
                $message->to($email)->subject('Invitacion a la reunion de '.$name);
            });
            
            return "Se envio por correo el enlace";
        
    }
    
    public function cambiar(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
        try{
            $email=$request->email;
            $password=$request->password;
            $nuevo_password=$request->nuevo_password;
            $error = false;
            $msg="";
            
            if (Auth::attempt(array('email' => $email, 'password' => $password)))
            {
                $user=User::where('email',[$email])->get()->first();
                $user->password=bcrypt($nuevo_password);
                $user->save();
                $msg="Se actualizo la contraseña correctamente";
            }
            else{
                $user=null;
                $error =true;
                $msg="Usuario o contraseña incorrectas";
            }    
        }
        
        catch(\Exception $e){
            $error=true;
            $msg=$e->getMessage();
        }
        
        return ["user"=>$user, "msg"=>$msg, "error"=>$error];
    }
    
    public function historico(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        header("Allow: GET, POST, OPTIONS");
        
        $error = false;
        $msg="";
        $historico=null;
        
        try{
            $pagina=$request->pagina;
            $accion=$request->accion;
            $usuario=$request->usuario;
            
            $historico = historico::create([
                'pagina' => $pagina,
                'accion' => $accion,
                'usuario' => $usuario,
            ]);
   
        }
        
        catch(\Exception $e){
            $error=true;
            $msg=$e->getMessage();
        }
        
        return ["historico"=>$historico, "msg"=>$msg, "error"=>$error];
    }    
    
    
    
    
    
    
}
