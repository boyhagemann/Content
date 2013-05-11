<?php

namespace Boyhagemann\Content\ResourceBuilder\Element;

use Form;

class ResourceSelect extends BaseElement
{
    protected $resourceName;
    
    /**
     * 
     * @param string $name
     * @param string $label
     * @param string $resourceName
     */
    public function __construct($name, $label, $resourceName) {
        parent::__construct($name, $label);
        
        $this->setResourceName($resourceName);
    }


    public function getResourceName() {
        return $this->resourceName;
    }

    public function setResourceName($resourceName) {
        $this->resourceName = $resourceName;
    }

    public function getFormHtml()
    {
        return Form::resourceSelect($this->getName(), $this->getResourceName());
    }
}