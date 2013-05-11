<?php

namespace Boyhagemann\Content\Model;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Block;
use Illuminate\Routing\Route;
use Str;

class Resource extends \Eloquent {

    protected $guarded = array();

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'resources';
    
    public static $rules = array(
        'title' => 'required',
        'name' => 'required',
        'class' => 'required',
    );

    /**
     * 
     * @param Page $page
     * @return Page
     */
    static public function createFromPage(Page $page)
    {
        $resourceDefaults = array('index', 'create', 'store', 'show', 'edit', 'update', 'delete', 'destroy');
        
        foreach($resourceDefaults as $action) {
            
            $pattern = sprintf('/[\w\.]+\.%s/', $action);
            preg_match($pattern, $page->name, $matches);
         
            // Ok, so this page is a resource page. We now want some other
            // content blocks on this page. We want to manage the resource
            // with a crud content block            
            if($matches) {                
                
                $page->layout_id = 1; // cms.layout
                $page->save();
                
                Resource::getOrCreateFromPage($page);
                
                return $page;
            }
        }
    }

    /**
     * 
     * @param Page $page
     * @return Resource
     */
    static public function getOrCreateFromPage(Page $page)
    {             
        $name = substr($page->name, 0, strrpos($page->name, '.'));

        $resource = Resource::where('name', '=', $name)->first();
        if(!$resource) {
            $names = explode('.', $name);
            $resource = new self();
            $resource->title = ucwords(end($names));
            $resource->name = $name;
            $resource->save();
        }
        return $resource;
    }
    
    /**
     * 
     * @param Route $route
     * @return Resource
     */
    static public function findOneByRoute(Route $route)
    {
        $routeName = $route->getOption('name');
        $name = substr($routeName, 0, strrpos($routeName, '.'));
        return self::findOneByName($name);
    }
    
    /**
     * 
     * @param Route $route
     * @return Resource
     */
    static public function findOneByName($name)
    {
        return self::where('name', '=', $name)->first();
    }
    
}