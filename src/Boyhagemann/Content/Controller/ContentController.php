<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Content\Model\Content;
use View, App;

class ContentController extends \BaseController
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
		$blocks = array();

		foreach(Content::findByPageAndSection($page, $section) as $content) {
			$blocks[] = $this->renderContent($content);
		}

		return View::make('content::section', compact('blocks'));
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

		$html = App::make('DeSmart\Layout\Layout')->dispatch($controller);

		return View::make('content::block', compact('html'));
	}
}