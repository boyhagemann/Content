<?php

namespace Boyhagemann\Content;

use Boyhagemann\Content\ResourceBuilder;
use Illuminate\Database\Eloquent\Collection;
use App;

class Overview
{
    /**
     *
     * @var Illuminate\Database\Eloquent\Collection
     */
    protected $collection;
    
    protected $resourceBuilder;
    
    protected $showElements = array();
    
    /**
     * 
     * @param ResourceBuilder $resourceBuilder
     */
    public function __contruct(ResourceBuilder $resourceBuilder)
    {
        $this->resourceBuilder = $resourceBuilder;
    }

    public function getResourceBuilder() {
        return $this->resourceBuilder;
    }

    public function setResourceBuilder(ResourceBuilder $resourceBuilder) {
        $this->resourceBuilder = $resourceBuilder;
    }
    
    public function getCollection() {
        return $this->collection;
    }

    public function setCollection(Collection $collection) {
        $this->collection = $collection;
    }

    /**
     * 
     * @param array $elementNames
     * @return Overview
     */
    public function showElements(Array $elementNames)
    {
        $this->showElements = $elementNames;
        return $this;
    }
    
    public function columns()
    {
        return $this->getResourceBuilder()->getElements();
    }

    public function render()
    {
        return 'test';
    }
}