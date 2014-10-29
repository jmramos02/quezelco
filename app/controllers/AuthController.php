<?php

use Quezelco\Interfaces\AccountRepository as Account;
use Quezelco\Interfaces\AuthRepository as Auth;
use Quezelco\Interfaces\LogRepository as Logger;

class AuthController extends BaseController{

	public function __construct(Auth $auth, Logger $logger, Account $account){
		$this->logger = $logger;
		$this->auth = $auth;
		$this->account = $account;
	}

	public function validateLogin(){
		$username = Input::get('username');
		$password = Input::get('password');
		$returnUrl = "";
		try{
			$credentials = array('username' => $username,
								 'password' => $password);
			$user = $this->auth->authenticate($credentials);
			$error = "";
			$returnUrl = $this->redirectToRoleUrl($user);
			$this->logger->add($user->id, true);
			return Redirect::to($returnUrl);
		}catch (Cartalyst\Sentry\Users\LoginRequiredException $e){
		    $error = 'Username is required.';
		}catch (Cartalyst\Sentry\Users\PasswordRequiredException $e){
		    $error = 'Password is required.';
		}catch (Cartalyst\Sentry\Users\WrongPasswordException $e){
		    $error = 'Either username or password is wrong try again.';
		}catch (Cartalyst\Sentry\Users\UserNotFoundException $e){
		    $error = 'User was not found.';
		}catch (Cartalyst\Sentry\Users\UserNotActivatedException $e){
		    $error = 'User is not activated.';
		}

		return View::make('login')->with('error_message',$error);
	}

	public function logout(){
		$user = $this->auth->getCurrentUser();
		$this->logger->add($user->id, false);
		$this->auth->logout();
		return View::make('login')->with('logout_message' ,'User Succesfully Logout');
	}

	public function redirectAlreadyLoggedIn(){
		$user = $this->auth->getCurrentUser();
		$returnUrl = $this->redirectToRoleUrl($user);
		return Redirect::to($returnUrl);
	}

	public function redirectToRoleUrl($user){
		if($user->inGroup($this->auth->findGroupByName('System Admin'))){
			return 'admin/home';
		}else if($user->inGroup($this->auth->findGroupByName('Cashier'))){
			return 'cashier/home';
		}else if($user->inGroup($this->auth->findGroupByName('Area Manager'))){
			return 'manager/home';
		}else if($user->inGroup($this->auth->findGroupByName('IT Personnel'))){
			return 'admin/home';
		}else if($user->inGroup($this->auth->findGroupByName('Collector'))){
			return 'collector/home';
		}else if ($user->inGroup($this->auth->findGroupByName('Consumers Area Department'))){
			return 'cad/home';
		} else {
			return 'consumer/home';
		}
	}

	public function showLoginForm(){
		if(Sentry::check()){
			$user = $this->auth->getCurrentUser();
			$returnUrl = $this->redirectToRoleUrl($user);
			return Redirect::to($returnUrl);
		}else{
			return View::make('login');	
		}
		
	}
	public function forgotPassword(){
		$username = Input::get('username');
		$first_name = Input::get('first_name');
		$last_name = Input::get('last_name');
		$cell_no = Input::get('cell_no');
		if(strlen(strval($cell_no)) != 10){
			return View::make('forgot-password')->with('error_message','Your cell number must be 10 digits');
		}else if(!is_numeric($cell_no)){
			return View::make('forgot-password')->with('error_message','Invalid Contact Number');
		}else{
			$user = User::where('username', '=', $username)
					->where('first_name', '=', $first_name)
					->where('last_name','=', $last_name)->first();
			if(is_null($user)){
				return View::make('forgot-password')->with('error_message','No user found');
			}else{
				$sentryUser = $this->auth->find($user->id);
				$length = 10;
				//generate random shit
				$randomString = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
				$sentryUser->password = $randomString;
				$sentryUser->save();
				$message = "Your new password is: " . $randomString . ' Please change your password immediately - Quezelco System Admin';
				Twilio::message('+63' . $cell_no, $message);
				return View::make('login')->with('message', 'Your new password is sent to your cellphone number');
			}
		}
	}
}