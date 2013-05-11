<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Content\Model\Resource;
use Boyhagemann\Content\ResourceBuilder;
use Boyhagemann\Content\Overview;
use App, View, Route, Input, Redirect, Validator;

class CrudController extends \BaseController {

    protected $resourceBuilder;
    
    protected $overview;
        
    /**
     * Model Repository
     *
     * @var Resource
     */
    protected $resource;
    
    public function __construct(Overview $overview, ResourceBuilder $resourceBuilder)
    {
        $this->overview = $overview;
        $this->resourceBuilder = $resourceBuilder;
        
        $overview->setResourceBuilder($resourceBuilder);
    }
    
    public function init()
    {
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->init();
        
        $resource = $this->getResource();
        $overview = $this->getOverview();
        
        $collection = $this->getModel()->get();
        $overview->setCollection($collection);
        
        return View::make('content::crud.index', compact('resource', 'overview'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->init();
        
        $resource = $this->getResource();
        $resourceBuilder = $this->getResourceBuilder();
                
        return View::make('content::crud.create', compact('resource', 'resourceBuilder'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
    }
    
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function content($id)
    {
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function delete($id)
    {
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
    }
    
    /**
     * 
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getModel()
    {        
        return App::make($this->getResourceBuilder()->getModelClass());
    }
    
    /**
     * 
     * @return Resource
     */
    public function getResource()
    {
        if(!$this->resource) {            
            $route = Route::getCurrentRoute()->getOption('originalRoute');
            $this->resource = Resource::findOneByRoute($route);
        }
        
        return $this->resource;
    }
    
    /**
     * 
     * @return Overview
     */
    public function getOverview()
    {
        return $this->overview;
    }
    
    /**
     * 
     * @return Overview
     */
    public function getResourceBuilder()
    {
        return $this->resourceBuilder;
    }
    
}