<?php

namespace app\controllers;

use Auth, BaseController, Session,Validator, Mail, Activity,Form, Input, Redirect, 
URL, Sentry, View, Payment,Crypt, Notification;

class LoginController extends \BaseController {

	/**
   * 显示登录页面
   * @return View
   */
  public function getLogin()
  {
    if(Sentry::check()){
    
    	return Redirect::route('login.show_policy');
    	
    }else{
    
    	return View::make('Login.login');
    
    }
  }
  
  public function postLogin()
  {
    $credentials = array(
      'email'    => Input::get('email'),
      'password' => Input::get('password')
    );
	if(Input::has('remember_me')){
	
		$remember_me = true;
		
	}else{
	
		$remember_me = false;
	}
	
    try
    {
      if($remember_me){
        $user = Sentry::authenticateAndRemember($credentials);
      }else{
      	$user = Sentry::authenticate($credentials, false);
      }
      
	//Debugbar::info($user);
      		if($user){
        		
            return Redirect::route('login.show_policy');

        	}else{
        		Notification::error('Email address or Password was not correct!');
        		//return Redirect::route('login')->withErrors(array('login' => $e->getMessage()));
        		return Redirect::route('login');
        	}	
        
      }
    
    catch(\Exception $e)
    {
      			Notification::error('Email address or Password was not correct!');
        		//return Redirect::route('login')->withErrors(array('login' => $e->getMessage()));
        		return Redirect::route('login');
    }
  }
  
   /**
   * 注销
   * @return Redirect
   */
  public function getLogout()
  {
    Sentry::logout();

    return redirect::route('login');
  }
  
  public function show_reset_password(){
  	
  	return View::make('Login.pwd_reset');
  	
  }
  
  public function email_confirm(){
  	try{
    	// Find the user using the user email address
    	$user = Sentry::findUserByLogin(Input::get('Email'));

   		 // Get the password reset code
    	$resetCode = $user->getResetPasswordCode();
		//echo URL::route('change_password',['resetCode'=>Crypt::encrypt($resetCode),'userid'=>Crypt::encrypt($user->id)]);
    	// Now you can send this code to your user via email for example.
      $data = ['email'=>$user->email, 'name'=>$user->last_name, 'uid'=>$user->id, 'activationcode'=>$resetCode];
      Mail::send('activemail', $data, function($message) use($data){
        $message->to($data['email'], $data['name'])->subject('【密码重置 Reset Password】');
      });
      Notification::success('An email with the link to Reset Password was sent to the address you provided,
         please follow it to complete the process.');
	   }catch (\Exception $e){
      	Notification::error( '没有发现该用户。User was not found.');
      	return redirect::back();
      }
    
    return redirect::back();
  
  }
  
  public function change_password($resetCode,$uid){
  	
  	try{	
		$user = Sentry::findUserById(Crypt::decrypt($uid));
		$email = $user->email;
		
		if ($user->checkResetPasswordCode(Crypt::decrypt($resetCode)))
		{
			return View::make('Login.pwd_change')->with('Email',$email)->with('uid',$uid)->with('resetCode',$resetCode);
		}
		else
		{

			Notification::error('The provided password reset code is Invalid');
			return View::make('Login.pwd_reset')->with('login','');
		}
		
	}catch (\Exception $e){
    	Notification::error('User was not found.');
	}

  	
}
  
  public function password_confirm(){
  	//$uid='';
  	//$resetCode='';
  	if(Input::has('uid')){
  
  		$uid = Input::get('uid');
  		
  
  	}
  	
  	if(Input::has('resetCode')){
  		
  		$resetCode = Input::get('resetCode');
  	
  	}
  		$rules = ['Password'=>'confirmed'];
  		$validator = Validator::make(Input::all(), $rules);
    	if($validator->fails()) {
  				//Former::withErrors($validator);
  				//return Redirect::to('change_password/'.$resetCode.'/'.$uid)->witherrors($validator);
        return Redirect::back()->witherrors($validator);
		}
  	
  	$user = Sentry::findUserById(Crypt::decrypt($uid));	
  	if($user->attemptResetPassword(Crypt::decrypt($resetCode),Input::get('Password'))){
  		Notification::success("Your password has been changed successfully.");
      return Redirect::Route('login');
  	}else{
  		
  		Notification::error("Change failed.");
      return Redirect::back()->withInput();
  		
  	}
  	
  }

  public function show_policy()
  {

      Session::put('activity_id',0);
      $activity = Activity::where('activated',1)->where('start','<',date('Y-m-d H:i:s',time()))
      ->where('end','>',date('Y-m-d H:i:s',time()))->orderBy('created_at','desc')->first();
      if($activity<>null){

        //Session::put('activity_id',$activity->id);
        return View::make('Login/policy')->with('activity',$activity);


      }else{
        
        return View::make('Login/na');


      }
      


  }

  public function confirm($activity_id)
  {

    Session::put('activity_id',$activity_id);
    return Redirect::route('items.index');

  }


  
}