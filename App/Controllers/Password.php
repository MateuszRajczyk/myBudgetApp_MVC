<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Flash;

class Password extends \Core\Controller
{
	public function forgotAction()
	{
		View::renderTemplate('Password/forgot.html');
	}
	
	public function requestResetAction()
	{
		if(User::sendPasswordReset($_POST['email']) == true)
		{
			View::renderTemplate('Password/checkEmailBox.html');
		}
		else
		{
			Flash::addMessage('Message was not send to '.$_POST['email'].' because the account does not exist', Flash::WARNING);
			View::renderTemplate('Password/forgot.html');
		}
	}
	
	public function resetAction()
	{
		$token = $this->route_params['token'];
		
		$user = $this->getUserOrExit($token);
		
		View::renderTemplate('Password/passwordResetForm.html', [
				'token' => $token
		]);
	}
	
	public function resetPasswordAction()
	{
		$token = $_POST['token'];
		
		$user = $this->getUserOrExit($token);
		
		if($user->resetPassword($_POST['password1']))
		{
			View::renderTemplate('Password/resetSuccess.html');
		}
		else
		{
			View::renderTemplate('Password/passwordResetForm.html', [
					'token' => $token,
					'user' => $user
			]);
		}
	}
	
	protected function getUserOrExit($token)
	{
		$user = User::findByPasswordReset($token);
		
		if($user)
		{
			return $user;
		}
		else
		{
			View::renderTemplate('Password/tokenExpired.html');
			exit;
		}	
	}
}