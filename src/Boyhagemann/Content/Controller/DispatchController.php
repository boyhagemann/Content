<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Content\Model\Content;
use View, App, URL, Route, Input;

class DispatchController extends \BaseController
{
	/**
	 * @param Page $page
	 * @return View
	 */
	public function renderPage(Page $page)
	{
		$layout = $page->layout;
		$vars = array();

		foreach($layout->sections as $section) {
			$vars[$section->name] = $this->renderSection($section, $page);
		}

		return View::make($layout->name, $vars);
	}

	/**
	 * @param Section $section
	 * @param Page    $page
	 * @return View
	 */
	public function renderSection(Section $section, Page $page)
	{
		if(Input::get('mode') == 'content') {

			// Build the form for adding a content block in this section
			$fb = App::make('Boyhagemann\Content\Controller\ContentController')->init('create')->getFormBuilder();
			$fb->action(URL::route('admin.content.store'));
			$fb->defaults(array(
				'section_id' => $section->id,
				'page_id' => $page->id,
			));
			$form = $fb->build();
		}

		// Dispatch all the blocks in this section
		$blocks = array();
		foreach(Content::findByPageAndSection($page, $section) as $content) {
			$blocks[] = $this->renderContent($content);
		}

		return View::make('content::section', compact('blocks', 'form'));
	}

	/**
	 * @param Content $content
	 * @return View
	 */
	public function renderContent(Content $content)
	{
		if($content->block) {
			$controller = $content->block->controller;
		}
		else {
			$controller = $content->controller;
		}

		$params = array_merge($content->params, Route::getCurrentRoute()->getParameters());
		$html = App::make('DeSmart\Layout\Layout')->dispatch($controller, $params);
		$mode = Input::get('mode');

		return View::make('content::block', compact('html', 'content', 'mode'));
	}
}