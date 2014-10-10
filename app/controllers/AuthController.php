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
		}else{
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
}