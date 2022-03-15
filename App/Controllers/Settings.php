<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\User;
use \App\Models\SettingsInfo;

class Settings extends Authenticated
{	
	public function userSetAction()
	{
		View::renderTemplate('Settings/userSettings.html',
			['name' => $_SESSION['username'],
			'email' => $_SESSION['email'],
			'password' => $_SESSION['password']]);
	}
	
	public function incomeSetAction()
	{
		$settingsInfo = new SettingsInfo();

		$getCategoryIncomes = $settingsInfo->getIncomeCategoriesInfo();

		header('Content-Type: application/json');

		echo json_encode($getCategoryIncomes);

	}
	
	public function expenseSetAction()
	{
		$settingsInfo = new SettingsInfo();

		$getCategoryExpenses = $settingsInfo->getExpenseCategoriesInfo();

		header('Content-Type: application/json');

		echo json_encode($getCategoryExpenses);
	}
	
	public function paymentSetAction()
	{
		$settingsInfo = new SettingsInfo();

		$getCategoryPayment = $settingsInfo->getPaymentMethodsCategoriesInfo();

		header('Content-Type: application/json');

		echo json_encode($getCategoryPayment);
	}

	public function editUserProfileAction()
	{
		$userAuth = User::authenticate($_SESSION['email'], $_POST['password']);

		$user = new User($_POST);
		
		if($userAuth && $user->editUserDetails())
		{
			if(isset($user->username)){
				Flash::addMessage('Username was successfuly updated');
			}else if(isset($user->email)){
				Flash::addMessage('Email was successfuly updated');
			}else if(isset($user->new_password)){
				Flash::addMessage('Password was successfuly updated');
			}
			

			View::renderTemplate('Settings/userSettings.html',
			['name' => $_SESSION['username'],
			'email' => $_SESSION['email'],
			'password' => $_SESSION['password']]);
		}
		else
		{
			$this->redirect('/settings/userSet');
		}
	}

}