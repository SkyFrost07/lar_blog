<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Validator;
use Mail;
use DB;

class AuthController extends Controller
{
    protected $user;
    
    public function __construct(\App\User $user) {
        $this->user = $user;
    }
    
    public function getRegister(){
        return view('auth.register');
    }
    
    public function postRegister(Request $request){
        $valid = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $this->user->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'gender' => $request->input('gender'),
        ]);
        
        return redirect()->back()->with('succ_mess', trans('auth.succ_register'));
    }
    
    public function getLogin(){
        return view('auth.login');
    }
    
    public function postLogin(Request $request){
        $valid = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $auth = auth()->attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->input('remember'));
        
        if(!$auth){
            return redirect()->back()->withInput()->with('error_mess', trans('auth.failed'));
        }
        
        return redirect()->intended(route('home'));
    }
    
    public function logout(){
        if(auth()->check()){
            auth()->logout();
        }
        return redirect()->route('get_login');
    }
    
    public function getForgetPass(){
        return view('auth.forget_password');
    }
    
    public function postForgetPass(Request $request){
        $valid = Validator::make($request->all(), [
           'email' => 'email|required|exists:users,email' 
        ]);
        if($valid->fails()){
            return redirect()->back()->withInput()->withErrors($valid->errors());
        }
        
        $email = $request->input('email');
        
        DB::beginTransaction();
        $user = $this->user->where('email', $email)->first();
        $token = makeToken(40, $this->user);
        $user->resetPasswdToken = $token;
        $user->resetPasswdExpires = time()+3600;
        $user->save();
        
        Mail::send('mails.reset_password', ['email' => $email, 'token' => $token], function($mail) use ($email){
            $mail->from(env('MAIL_USERNAME'), env('MAIL_NAME'));
            $mail->to($email);
            $mail->subject(trans('auth.reset_pass_subject', ['host' => request()->getHost()]));
        });
        if(count(Mail::failures()) > 0){
            DB::rollBack();
            return redirect()->back()->withInput()->with('error_mess', trans('auth.failure_send_mail'));
        }
        
        DB::commit();
        return redirect()->back()->with('succ_mess', trans('auth.reset_pass_mail_sent'));        
    }
    
    public function getResetPass(Request $request){
        $valid = Validator::make($request->all(), [
            'token' => 'required'
        ]);
        $error_view = view('errors.alert', ['mess' => trans('error.invalid_token')]);
        if($valid->fails()){
            return $error_view;
        }
        
        $token = $request->get('token');
        $user = $this->user->where('resetPasswdToken', $token)->where('resetPasswdExpires', '>', time())->first();
        if(!$user){
            return $error_view;
        }
        return view('auth.reset_password', ['token' => $token]);
    }
    
    public function postResetPass(Request $request){
        $valid = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);
        if($valid->fails()){
           return redirect()->back()->withInput()->withErrors($valid->errors()); 
        }
        
        $token = $request->input('token');
        $user = $this->user->where('resetPasswdToken', $token)->where('resetPasswdExpires', '>', time())->first();
        if(!$user){
            return view('errors.alert', ['mess' => trans('error.invalid_token')]);
        }
        
        $user->password = bcrypt($request->input('password'));
        $user->resetPasswdToken = '';
        $user->resetPasswdExpires = 0;
        $user->save();
        
        return redirect()->route('get_login')->with('succ_mess', trans('auth.reset_pass_success'));
    }
    
}
