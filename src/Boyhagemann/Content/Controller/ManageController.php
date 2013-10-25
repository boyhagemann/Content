<?php

namespace Boyhagemann\Content\Controller;

use View, Request, Session, Redirect;

class ManageController extends \BaseController
{
	public function toolbar()
	{
		switch(Request::get('mode')) {

			case 'view':
				Session::put('mode', 'view');
				return Redirect::refresh();
				break;

			case 'content':
				Session::put('mode', 'content');
				return Redirect::refresh();
				break;
		}

		if(!Session::get('mode')) {
			Session::put('mode', 'view');
		}

		$mode = Session::get('mode');

		return View::make('content::manage.toolbar', compact('mode'));
	}
}