<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		return view('dashboard/index');
	}
	
	public function myview()
	{
		return view('myView');
	}
}
