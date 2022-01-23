<?php

namespace App\Controllers;

use \Core\View;
use \App\Auth;
use \App\Models\searchFinance;

class Balance extends Authenticated
{	
	
	public function currentMonthAction()
	{
		$currentMonthData = new searchFinance();
		
		$currentMonthData->currentMonth();
		
		View::renderTemplate('Balance/finance-balance.html', ['financeData' => $currentMonthData]);
	}
	
	public function lastMonthAction()
	{
		$lastMonthData = new searchFinance();
		
		$lastMonthData->lastMonth();
		
		View::renderTemplate('Balance/finance-balance.html', ['financeData' => $lastMonthData]);
	}
	
	public function currentYearAction()
	{
		$currentYearData = new searchFinance();
		
		$currentYearData->currentYear();
		
		View::renderTemplate('Balance/finance-balance.html', ['financeData' => $currentYearData]);
	}
	
	
	

}