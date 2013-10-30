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
		$fb->hidden('layout_id');
		$fb->hidden('page_id');
		$fb->hidden('section_id');
		$fb->hidden('position')->value(0);
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
	 * Redirect to the content configuration form.
	 *
	 * Right after the content block has been created, we can hook into the
	 * save method and redirect to a configuration form. There we can set
	 * the needed params required for this content block to work.
	 *
	 * It uses the ResponseException instead of the normal Redirect object.
	 * This is because a normal redirect will not work, because that
	 * object is never returned as a view. But now we throw a special
	 * exception that will do the trick for us.
	 *
	 * @param Content $content
	 */
	public function onSaved(Content $content)
	{
		$redirect = Redirect::route('admin.content.config.edit', $content->id);
		return ResponseException::chain($redirect)->fire();
	}

}