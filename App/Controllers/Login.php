<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Auth;
use \App\Flash;

class Login extends \Core\Controller
{
	public function newAction()
	{
		if(Auth::getUser())
		{
			$this->redirect(Auth::getReturnToPage());
		}
		
		
		View::renderTemplate('Home/index.html');
	}
	
	public function createAction()
	{
		$user = User::authenticate($_POST['email'], $_POST['password']);
		
		$rememberMe = isset($_POST['rememberMe']);
		
		if ($user)
		{
			if(!$user->isActive)
			{
				Flash::addMessage('Your account is not active. Please check your email box.', Flash::WARNING);
				
				View::renderTemplate('Home/index.html');
			}
			else
			{
				Auth::login($user, $rememberMe);
				
				Flash::addMessage('Login successful');
				
				$this->redirect(Auth::getReturnToPage());
			}
		}
		else
		{
			
			View::renderTemplate('Home/index.html', [
				'email' => $_POST['email'],
				'rememberMe' => $rememberMe
			]);
		}
	}
	
	public function menuAction()
    {
        View::renderTemplate('UserMenu/home-user-website.html');
    }
	
	public function logoutAction()
	{
		Auth::logout();
		
		$this->redirect('/login/show-logout-message');
	}
	
	public function showLogoutMessageAction()
	{
		Flash::addMessage('Logout seccessful');
		
		$this->redirect('/home/index');
	}
}