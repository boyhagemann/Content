<?php namespace Boyhagemann\Content;

use Illuminate\Support\ServiceProvider;
use Route, Form;

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
        
        Route::get('testform', 'Boyhagemann\Content\Controller\TestController@form');
        
        
        
        
        
        
        
        Form::macro('modelSelect', function($name, $model, Array $options = array()) {                        
            return Form::select($name, Form::multiOptionsFromModel($model, $options));
        });
                
        Form::macro('modelCheckbox', function($name, $model, Array $options = array()) {            
            return Form::multiCheckbox($name, Form::multiOptionsFromModel($model, $options));
        });
                
        Form::macro('modelRadio', function($name, $model, Array $options = array()) {
            return Form::multiRadio($name, Form::multiOptionsFromModel($model, $options));
        });
                
        Form::macro('multiCheckbox', function($name, $multiOptions) {
            
            $inputs = array();
            foreach($multiOptions as $key => $value) {
                $inputName = sprintf('%s[%s]', $name, $key);
                $inputs[] =                 
                Form::checkbox($name, $key, null, array(
                    'id' => $inputName,
                )) . 
                Form::label($inputName, $value);
            }
            return implode('<br>', $inputs);
        });        
        
        Form::macro('multiRadio', function($name, $multiOptions) {
            
            $inputs = array();
            foreach($multiOptions as $key => $value) {
                $inputName = sprintf('%s_%s', $name, $key);
                $inputs[] = 
                Form::radio($name, $key, null, array(
                    'id' => $inputName,
                )) . 
                Form::label($inputName, $value);
            }
            return implode('<br>', $inputs);
        });
        
        Form::macro('multiOptionsFromModel', function($model, Array $options = array()) {
            
            if(is_string($model)) {
                $model = \App::make($model);
            } 
                
            if(!isset($options['keyField'])) {
                $options['keyField'] = 'id';
            }
                
            if(!isset($options['valueField'])) {
                $options['valueField'] = 'title';
            }
            
            $multiOptions = array();
            foreach($model->all() as $record) {
                $multiOptions[$record->{$options['keyField']}] = $record->{$options['valueField']};
            }
            
            return $multiOptions;
        });
        
        
        
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