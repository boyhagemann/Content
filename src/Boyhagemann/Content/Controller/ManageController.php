<?php

namespace Boyhagemann\Content\Controller;

use View, Request, Session;

class ManageController extends \BaseController
{
	public function toolbar()
	{
		switch(Request::get('mode')) {

			case 'view':
				Session::put('mode', 'view');
				break;

			case 'content':
				Session::put('mode', 'content');
				break;
		}

		if(!Session::get('mode')) {
			Session::put('mode', 'view');
		}

		$mode = Session::get('mode');

		return View::make('content::manage.toolbar', compact('mode'));
	}
}