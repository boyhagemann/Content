<?php namespace Boyhagemann\Content;

use Illuminate\Support\ServiceProvider;
use Boyhagemann\Content\Model\Block;
use Boyhagemann\Pages\Model\Section;
use Boyhagemann\Pages\Model\Page;
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

		Event::listen('page.createWithContent', function(Page $page) {

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