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

class ContentController extends CrudController
{
	/**
	 * @param FormBuilder $fb
	 */
	public function buildForm(FormBuilder $fb)
	{
		$fb->modelSelect('block_id')->model('Boyhagemann\Content\Model\Block');
		$fb->hidden('page_id');
		$fb->hidden('section_id');
		$fb->hidden('position')->value(0);
	}

	/**
	 * @param Content $content
	 */
	public function onSaved(Content $content)
	{
		$redirect = Redirect::route('admin.content.config.form', $content->id);
		return ResponseException::chain($redirect)->fire();
	}

	/**
	 * @param ModelBuilder $mb
	 */
	public function buildModel(ModelBuilder $mb)
	{
		$mb->name('Boyhagemann\Content\Model\Content')->table('content');
	}

	/**
	 * @param OverviewBuilder $ob
	 */
	public function buildOverview(OverviewBuilder $ob)
	{
	}

	/**
	 * @param Content $content
	 * @return mixed
	 */
	public function configForm(Content $content)
	{
		$block = $content->block;

		// Check if there is a form configuration present for this block
		list($controller, $action) = explode('@', $block->controller);
		if(!method_exists($controller, $action . 'Config')) {
			Redirect::route($content->page->route);
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
	public function configUpdate(Content $content)
	{
		$content->params = Input::all();
		$content->save();

		return Redirect::route($content->page->route);
	}

}