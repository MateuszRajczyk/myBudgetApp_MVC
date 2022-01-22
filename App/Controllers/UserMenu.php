<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;

class UserMenu extends Authenticated
{
	public function usermainAction()
	{
		View::renderTemplate('UserMenu/home-user-website.html');
	}
}