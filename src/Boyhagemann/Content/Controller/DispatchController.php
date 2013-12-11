<?php

namespace Boyhagemann\Content\Controller;

use Illuminate\Database\Eloquent\Collection;
use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Layout;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Content\Model\Content;
use View,
    App,
    URL,
    Route,
    Session,
    Event;

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

        $content = Content::findByPage($page);

        foreach ($layout->sections as $section) {
            $vars[$section->name] = $this->renderSection($section, $content);
        }

        return View::make($layout->name, $vars);        
    }

    /**
     * @param Section $section
     * @param Page    $page
     * @return View|null
     */
    public function renderSection(Section $section, Collection $content)
    {
        $isContentMode = Session::get('mode') == 'content';
        $isModePublic = $section->isPublic();
        
        // Dispatch all the blocks in this section
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
                'page_id' => $section->page_id,
            ));
            $form = $fb->build();
        }
        elseif (!$content->count() || implode('', $blocks) === '') {
            return;
        }
        
        Event::fire('content.dispatch.renderSection', array(&$blocks, $section, $section->page, $isContentMode, $isModePublic));
        
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
            $response = $this->renderController($controller, $content->params);

            if (!$response) {
                return;
            }
            
        } 
        catch (\RuntimeException $e) {
            $response = '--- Block not configured properly: missing required fields ---';
        }
        
        Event::fire('content.dispatch.renderContent', array($response, $content));

        return View::make('content::block', compact('response', 'content', 'isContentMode', 'isModePublic', 'hasConfigForm'));
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