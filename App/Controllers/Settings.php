<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;

class Settings extends Authenticated
{	
	public function userSetAction()
	{
		View::renderTemplate('Settings/userSettings.html');
	}
	
	public function incomeSetAction()
	{
		View::renderTemplate('Settings/incomeSettings.html');
	}
	
	public function expenseSetAction()
	{
		View::renderTemplate('Settings/expenseSettings.html');
	}
	
	public function paymentSetAction()
	{
		View::renderTemplate('Settings/paymentMethodsSettings.html');
	}

}