<?php

namespace Boyhagemann\Content\Filter;

use Boyhagemann\Content\Model\PageRepository;
use Route, Request, App, Str;

/**
 * Each time a resource page is created, we add the appropriate content on that page.
 */

class DispatchPageContentBlocksFilter {

	public function filter(\Illuminate\Routing\Route $route)
	{
		$alias 	= Route::currentRouteName();
		$method = Str::lower(Request::getMethod());
		$page 	= PageRepository::findPageByAliasAndMethod($alias, $method);

		if($page) {
			return App::make('DeSmart\Layout\Layout')->dispatch('Boyhagemann\Content\Controller\DispatchController@renderPage', compact('page'));
		}

	}

}