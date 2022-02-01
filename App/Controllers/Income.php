<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Flash;
use \App\Models\addIncome;

class Income extends Authenticated
{
	protected $incomeCategory;
	protected $isSended;
	
	protected function before()
	{
		$this->incomeCategory = addIncome::incomeCategoryName();
	}
	
	public function newAction()
	{
		View::renderTemplate('AddIncome/add-income.html', ['incomeCategory' => $this->incomeCategory]);
	}
	
	public function addAction()
	{
		$income = new addIncome($_POST);
		
		
		if($income->sendIncomeToDB())
		{
			Flash::addMessage('The income which you entered has been successfully added.');
			$this->redirect('/income/new');
		}
		else
		{
			View::renderTemplate('AddIncome/add-income.html', [
                'income' => $income,
				'incomeCategory' => $this->incomeCategory
            ]);
		}
	}

}