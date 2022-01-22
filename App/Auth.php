<?php

namespace App;

use App\Models\User;
use App\Models\RememberedLogin;

class Auth
{
	public static function login($user, $rememberMe)
	{
		session_regenerate_id(true);
		
		$_SESSION['user_id'] = $user->id;
		$_SESSION['username'] = $user->username;
		
		if($rememberMe)
		{
			if($user->rememberLogin())
			{
				setcookie('rememberMe', $user->rememberToken, $user->expiryTimestamp, '/');
			}
		}
		
	}
	
	public static function logout()
	{
		$_SESSION = [];
		
		if(ini_get('session.use_cookies'))
		{
			$params = session_get_cookie_params();
			
			setcookie(
				session_name(),
				'',
				time() - 42000,
				$params['path'],
				$params['domain'],
				$params['secure'],
				$params['httponly']
			);
		}
		
		session_destroy();
		
		static::forgetLogin();
	}
	
	public static function rememberRequestedPage()
	{
		$_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
	}
	
	public static function getReturnToPage()
	{		
        if(isset($_SESSION['return_to']))
		{
			return $_SESSION['return_to'];
		}
		else
		{
			return '/usermenu/usermain';
		}
	}
	
	public static function getUser()
	{
		if(isset($_SESSION['user_id']))
		{
			return User::findByID($_SESSION['user_id']);
		}else{
			return static::loginFromRememberCookie();
		}
	}
	
	public static function loginFromRememberCookie()
	{
		$cookie = $_COOKIE['rememberMe'] ?? false;
		
		if($cookie)
		{
			$rememberedLogin = RememberedLogin::findByToken($cookie);
			
			if ($rememberedLogin && !$rememberedLogin->hasExpired())
			{
				$user = $rememberedLogin->getUser();
				
				static::login($user, false);
				
				return $user;
			}
		}
	}
	
	protected static function forgetLogin()
	{
		$cookie = $_COOKIE['rememberMe'] ?? false;
		
		if($cookie)
		{
			$rememberedLogin = RememberedLogin::findByToken($cookie);
			
			if($rememberedLogin)
			{
				$rememberToken->delete();
			}
			
			setcookie('rememberMe', time() - 3600); // set to expire in the past
		}
	}
}