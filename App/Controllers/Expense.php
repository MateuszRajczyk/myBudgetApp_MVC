<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\addExpense;

class Expense extends Authenticated
{
	protected $expenseCategory;
	
	protected function before()
	{
		$this->expenseCategory = addExpense::ExpenseCategoryName();
		$this->paymentMethod = addExpense::ExpensePaymentName();
	}
	
	public function newAction()
	{
		
		View::renderTemplate('AddExpense/add-expense.html', ['expenseCategory' => $this->expenseCategory, 'paymentMethod' => $this->paymentMethod]);
	}
	
	public function addAction()
	{
		$expense = new addExpense($_POST);
		
		
		if($expense->sendExpenseToDB())
		{
			Flash::addMessage('The expense which you entered has been successfully added.');
			$this->redirect('/expense/new');
		}
		else
		{
			View::renderTemplate('AddExpense/add-expense.html', [
                'expense' => $expense,
				'expenseCategory' => $this->expenseCategory
            ]);
		}
	}

	public function showLimitInfoCategoryAction()
	{
		$expense = new addExpense($_POST);

		$limit = $expense->getLimitInfoCategory();

		header('Content-Type: application/json');

		echo json_encode($limit);
	}

}