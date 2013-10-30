<?php namespace Boyhagemann\Content;

use Illuminate\Support\ServiceProvider;
use Boyhagemann\Content\Model\Block;
use Boyhagemann\Content\Model\Content;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Pages\Model\Page;
use DeSmart\ResponseException\Exception as ResponseException;

use Route, Form, App, Event;

class ContentServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('boyhagemann/content');

        $this->app->register('DeSmart\Layout\LayoutServiceProvider');
        $this->app->register('DeSmart\ResponseException\ResponseExceptionServiceProvider');

		/**
		 * Each time a resource page is created, we add the appropriate content on that page.
		 */
		Event::listen('page.createResourcePage', function(Page $page) {


			// Check if there already is content attached to this page.
			// If so, then we don't have to add new content.
			if(Model\Content::wherePageId($page->id)->first()) {
				return;
			}
                        
			$block = Block::whereController($page->controller)->first();
			$section = Section::whereName('content')->first();

			$content = new Model\Content;
			$content->page()->associate($page);
			$content->section()->associate($section);

			if($block) {
				$content->block()->associate($block);
			}
			else {
				$content->controller = $page->controller;
			}

			$content->save();

		});

		/**
		 * If a page is created with no block yet, add a content block on that page
		 * with the same controller. This gives the user more control on where to
		 * place the content later on.
		 */
		Event::listen('page.createWithContent', function(Page $page) {
                    
			// If the page doesn't have a controller, then we can do nothing
			if(!$page->controller) {
				return;
			}

			// Check if there already is content attached to this page.
			// If so, then we don't have to add new content.
			if(Model\Content::wherePageId($page->id)->first()) {
				return;
			}
 
			// Get the main content section
			$section = Section::whereName('content')->first();

			// Create the new content
			$content = new Model\Content;
			$content->page()->associate($page);
			$content->section()->associate($section);
			$content->controller = $page->controller;
			$content->save();
                       
		});
                
                Event::listen('content.dispatch.renderContent', function($response, Content $content) {
                    
                    // Catch a Redirect response
                    if($response instanceof \Illuminate\Http\RedirectResponse) {                        
                        ResponseException::chain($response)->fire();
                    }
                    
                });

		// Every route with the parameter {content} will now have
		// the Content model out of the box.
		Route::model('content', 'Boyhagemann\Content\Model\Content');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}