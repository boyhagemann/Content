<?php

namespace Boyhagemann\Content\Subscriber;

use Illuminate\Events\Dispatcher as Events;
use Boyhagemann\Content\Model\Content;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\Eloquent\Model;
use DeSmart\ResponseException\Exception as ResponseException;
use Input, App, Redirect, Route;

/**
 * If a page is created with no block yet, add a content block on that page
 * with the same controller. This gives the user more control on where to
 * place the content later on.
 */
class HandleRedirectResponse
{
	/**
	 * Register the listeners for the subscriber.
	 *
	 * @param Events $events
	 */
	public function subscribe(Events $events)
	{
		$events->listen('content.dispatch.renderContent', array($this, 'handleRedirectResponse'));
	}

	/**
	 * @param         $response
	 * @param Content $content
	 */
	public function handleRedirectResponse($response, Content $content)
	{
		// Catch a Redirect response
		if($response instanceof RedirectResponse) {
			ResponseException::chain($response)->fire();
		}
	}

}