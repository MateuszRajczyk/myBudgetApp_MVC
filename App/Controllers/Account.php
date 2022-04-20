<?php 

namespace App\Controllers;

use \App\Models\addExpense;
use \App\Models\addIncome;
use \App\Models\User;

class Account extends \Core\Controller
{
	//(AJAX) validate if email is available
	public function validateEmailAction()
	{
		$isEmailValid = !User::emailExists($_GET['email']);
		
		header('Content-Type: application/json');
		
		echo json_encode($isEmailValid);
	}

	public function isIncomeCategoryExistsAction()
	{
		$isNewCategoryValid = !addIncome::categoryIncomeExists($_GET['categoryAdded']);
		
		header('Content-Type: application/json');
		
		echo json_encode($isNewCategoryValid);
	}

	public function isExpenseCategoryExistsAction()
	{
		$isNewCategoryValid = !addExpense::categoryExpenseExists($_GET['categoryAdded']);
		
		header('Content-Type: application/json');
		
		echo json_encode($isNewCategoryValid);
	}

	public function isPaymentCategoryExistsAction()
	{
		$isNewCategoryValid = !addExpense::categoryPaymentExists($_GET['categoryAdded']);
		
		header('Content-Type: application/json');
		
		echo json_encode($isNewCategoryValid);
	}

}