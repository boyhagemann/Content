<?php

namespace Boyhagemann\Content;

use Boyhagemann\Content\ResourceBuilder\Element\ElementInterface;

class ResourceBuilder
{
    protected $modelClass;
    
    /**
     *
     * @var array
     */
    protected $elements = array();
    
    public function getModelClass() {
        return $this->modelClass;
    }

    public function setModelClass($modelClass) {
        $this->modelClass = $modelClass;
    }
        
    /**
     * 
     * @param ElementInterface $element
     * @return ResourceBuilder
     */
    public function addElement(ElementInterface $element)
    {
        $this->elements[$element->getName()] = $element;
        return $this;
    }
    
    /**
     * 
     * @return array
     */
    public function getElements()
    {
        return $this->elements;
    }
}