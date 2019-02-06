<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
	/**
	 * Return home page
	 */
	public function home()
	{
		return view('content.index');
	}
}
