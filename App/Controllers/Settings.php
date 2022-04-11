<?php

namespace App\Controllers;

use \Core\View;
use \App\Flash;
use App\Models\addExpense;
use App\Models\addIncome;
use \App\Models\User;
use \App\Models\SettingsInfo;

class Settings extends Authenticated
{	
	public function profileSettingsAction()
	{
		$settingsInfo = new SettingsInfo();

		$getCategoryIncomes = $settingsInfo->getIncomeCategoriesInfo();
		$getCategoryExpenses = $settingsInfo->getExpenseCategoriesInfo();
		$getCategoryPayment = $settingsInfo->getPaymentMethodsCategoriesInfo();

		View::renderTemplate('Settings/settings.html',
			['name' => $_SESSION['username'],
			'email' => $_SESSION['email'],
			'password' => $_SESSION['password'],
			'incomeCategory' => $getCategoryIncomes,
			'expenseCategory' => $getCategoryExpenses,
			'paymentCategory' => $getCategoryPayment]);
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
			
			View::renderTemplate('Settings/settings.html',
			['name' => $_SESSION['username'],
			'email' => $_SESSION['email'],
			'password' => $_SESSION['password']]);
		}
		else
		{
			$this->redirect('/settings/editUserProfile');
		}
	}

	public function editIncomeCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$editIncome = $settingsInfo->editIncomeCategory();

		if($editIncome){
			Flash::addMessage('Income category was successfuly updated');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function deleteIncomeCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$deleteIncome = $settingsInfo->deleteIncomeCategory();

		addIncome::deleteIncomesAssignedToGivenCategory($settingsInfo);

		if($deleteIncome){
			Flash::addMessage('Income category was successfuly deleted');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function addIncomeCategory()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$addIncome = $settingsInfo->addIncomeCategory();

		if($addIncome){
			Flash::addMessage('Income category was successfuly added');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}
	
	public function editExpenseCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$editExpense = $settingsInfo->editExpenseCategory();

		if($editExpense){
			Flash::addMessage('Expense category was successfuly updated');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function deleteExpenseCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$deleteExpense = $settingsInfo->deleteExpenseCategory();

		addExpense::deleteExpensesAssignedToGivenCategory($settingsInfo);

		if($deleteExpense){
			Flash::addMessage('Expense category was successfuly deleted');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function addExpenseCategory()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$addExpense = $settingsInfo->addExpenseCategory();

		if($addExpense){
			Flash::addMessage('Expense category was successfuly added');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function editPaymentCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$editPayment = $settingsInfo->editPaymentCategory();

		if($editPayment){
			Flash::addMessage('Payment method category was successfuly updated');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function deletePaymentCategoryAction()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$deletePayment = $settingsInfo->deletePaymentCategory();

		addExpense::deleteExpensesAssignedToGivenPaymentMethod($settingsInfo);

		if($deletePayment){
			Flash::addMessage('Payment method was successfuly deleted');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function addPaymentCategory()
	{
		$settingsInfo = new SettingsInfo($_POST);

		$addPayment = $settingsInfo->addPaymentCategory();

		if($addPayment){
			Flash::addMessage('Payment method was successfuly added');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');
	}

	public function deleteBalanceAction()
	{
		$settings = new SettingsInfo();

		$deleteBalance = $settings->deleteAllData();

		if($deleteBalance){
			Flash::addMessage('All incomes and expenses was successfully deleted from your account');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/settings/profileSettings');

	}

	public function deleteAccountAction()
	{
		$user = new User();

		$deleteUser = $user->deleteAccount();

		if($deleteUser){
			Flash::addMessage('Your account was successfully deleted from system');
		}else{
			Flash::addMessage('Something goes wrong', Flash::WARNING);
		}

		$this->redirect('/');

	}

}