<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Crud\CrudController;
use Boyhagemann\Form\FormBuilder;
use Boyhagemann\Model\ModelBuilder;
use Boyhagemann\Overview\OverviewBuilder;

use Boyhagemann\Content\Model\Content;
use Boyhagemann\Content\Model\Block;
use DeSmart\ResponseException\Exception as ResponseException;

use App, Form, Input, Redirect, Layout, Str;

class ConfigController extends \BaseController
{
	/**
	 * @param Content $content
	 * @return mixed
	 */
	public function edit(Content $content)
	{
		$block = $content->block;

		// Check if there is a form configuration present for this block
		list($controller, $action) = explode('@', $block->controller);
		if(!method_exists($controller, $action . 'Config')) {
			Redirect::route($content->page->alias);
		}

		// Render the configuration form
		$fb = App::make('Boyhagemann\Form\FormBuilder');
		$fb->action(\URL::route('admin.content.config.update', $content->id));
		Layout::dispatch($block->controller . 'Config', compact('fb'));
		$fb->defaults($content->params);

		return Form::render($fb->build());
	}

	/**
	 * @param Content $content
	 * @return mixed
	 */
	public function update(Content $content)
	{
		$content->params = Input::all();
		$content->save();

		return Redirect::route($content->page->alias);
	}

}