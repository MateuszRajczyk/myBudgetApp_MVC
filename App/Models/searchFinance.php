<?php

namespace App\Models;

use PDO;
use App\Date;

class searchFinance extends \Core\Model
{
	public $errorAddIncome = [];
	
	public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }
	
	public function currentMonth()
	{
		$this->startDate = Date::getStartCurrentDate();
		$this->endDate = Date::getEndCurrentDate();
	}
	
	public function lastMonth()
	{
		$this->startDate = Date::getStartLastMonthDate();
		$this->endDate = Date::getEndLastMonthDate();
	}
	
	public function currentYear()
	{
		$this->startDate = Date::getStartCurrentYearDate();
		$this->endDate = Date::getEndCurrentYearDate();
	}
	
	
	

}