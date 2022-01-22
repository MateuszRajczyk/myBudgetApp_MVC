<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;

class Password extends \Core\Controller
{
	public function forgotAction()
	{
		View::renderTemplate('Password/forgot.html');
	}
	
	public function requestResetAction()
	{
		User::sendPasswordReset($_POST['email']);
		
		View::renderTemplate('Password/checkEmailBox.html');
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
		
		if($user->resetPassword($_POST['password1'], $_POST['password2']))
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