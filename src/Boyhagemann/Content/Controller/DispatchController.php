<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Layout;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Content\Model\Content;
use View,
    App,
    URL,
    Route,
    Session,
    Event,
    stdClass;

class DispatchController extends \BaseController
{

    /**
     * @param Page $page
     * @return View
     */
    public function renderPage(Page $page)
    {
        if(!$page->layout && $page->controller) {
            return $this->renderController($page->controller);
        }
        
        return $this->renderPageWithLayout($page);
    }
    
    /**
     * 
     * @param Layout $layout
     * @param Page $page
     * @return View|null
     */
    public function renderPageWithLayout(Page $page)
    {
        $layout = $page->layout;
        $vars = array();

        foreach ($layout->sections as $section) {
            $vars[$section->name] = $this->renderSection($section, $page, false);
        }

        return View::make($layout->name, $vars);        
    }

    /**
     * @param Section $section
     * @param Page    $page
     * @return View|null
     */
    public function renderSection(Section $section, Page $page)
    {
        $isContentMode = Session::get('mode') == 'content';
        $isModePublic = $section->isPublic();
        
        // Dispatch all the blocks in this section
//        $content = Content::findByPageAndSection($page, $section);
        $content = $page->content;
        
        $blocks = array();        
        foreach ($content as $item) {
            if($item->section_id == $section->id) {
                $blocks[] = $this->renderContent($item);
            }
        }

        if ($isContentMode) {

            // Build the form for adding a content block in this section
            $fb = App::make('Boyhagemann\Content\Controller\ContentController')->init('create')->getFormBuilder();
            $fb->url(URL::route('admin.content.store'));
            $fb->defaults(array(
                'section_id' => $section->id,
                'page_id' => $page->id,
            ));
            $form = $fb->build();
        }
        elseif (!$content->count() || implode('', $blocks) === '') {
            return;
        }
        
        Event::fire('content.dispatch.renderSection', array(&$blocks, $section, $page, $isContentMode, $isModePublic));
        
        return View::make('content::section', compact('blocks', 'section', 'form', 'isContentMode', 'isModePublic'));
    }

    /**
     * @param Content $content
     * @return View|null
     */
    public function renderContent(Content $content)
    {
        $isContentMode = Session::get('mode') == 'content';
		$isModePublic = $content->section->isPublic();
        $hasConfigForm = $content->hasConfigForm();

        if ($content->block) {
            $controller = $content->block->controller;
        }
        else {
            $controller = $content->controller;
        }

        try {
            $html = $this->renderController($controller, $content->params);

            if (!$html) {
                return;
            }
            
        } 
        catch (\RuntimeException $e) {
            $html = '--- Block not configured properly: missing required fields ---';
        }

        Event::fire('content.dispatch.renderContent', array($html, $content));

        return View::make('content::block', compact('html', 'content', 'isContentMode', 'isModePublic', 'hasConfigForm'));
    }
    
    /**
     * 
     * @param string $controller
     * @param array $params
     * @return View
     */
    public function renderController($controller, $params = array())
    {
        $params = array_merge($params, Route::getCurrentRoute()->getParameters());
        
        return App::make('layout')->dispatch($controller, $params);
    }

}