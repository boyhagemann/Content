<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;

use Boyhagemann\Content\Model\Content;
use Boyhagemann\Content\Model\Block;
use DeSmart\ResponseException\Exception as ResponseException;

use App, Form, Input, Redirect, Request, Layout, Str, Route, Session;

class ConfigController extends \BaseController
{
	/**
	 * @param Content $content
	 * @return mixed
	 */
	public function edit(Content $content)
	{
		// Get the previous page and store it in a session. We need this page later to go back to.
		$referer = Request::header('referer');
		Session::put('referer', $referer);

		$block = $content->block;

		// Check if there is a form configuration present for this block
		list($controller, $action) = explode('@', $block->controller);
		if(!method_exists($controller, $action . 'Config')) {
			Redirect::to($referer);
		}

		// Build the configuration form
		$fb = App::make('Boyhagemann\Form\FormBuilder');
		$fb->action(\URL::route('admin.content.config.update', $content->id));

		// Now call the config method and give the form to the user.
		// The user can add elements to the configuration form.
		Layout::dispatch($block->controller . 'Config', compact('fb'));

		// After the form is completely built we can set the values
		// we might already have for this content block.
		$fb->defaults($content->params);

		// Return the html with the form
		return Form::render($fb->build());
	}

	/**
	 * @param Content $content
	 * @return mixed
	 */
	public function update(Content $content)
	{
		// Store the content from the configuration form
		$content->params = Input::all();
		$content->save();

		// Redirect to the page where the content is placed on.
		return Redirect::to(Session::get('referer'));
	}

}