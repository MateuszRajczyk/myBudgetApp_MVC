<?php

namespace App;

class Date 
{
	public static function getCurrentDate()
	{
		return date('Y-m-d');
	}
	
	public static function getStartCurrentDate()
	{
		return date('Y-m-01');
	}
	
	public static function getEndCurrentDate()
	{
		return date('Y-m-t');
	}
	
	public static function getStartLastMonthDate()
	{
		return date('Y-n-j', strtotime('first day of previous month'));
	}
	
	public static function getEndLastMonthDate()
	{
		return date('Y-n-j', strtotime('last day of previous month'));
	}
	
	public static function getStartCurrentYearDate()
	{
		return date('Y-n-j', strtotime('first day of this year'));
	}
	
	public static function getEndCurrentYearDate()
	{
		return date('Y-n-j', strtotime('last day of December this year'));
	}
}