<?php

namespace Boyhagemann\Content\ResourceBuilder\Element;

use Illuminate\Database\Eloquent\Model;

abstract class BaseElement implements ElementInterface
{
    protected $name;
    protected $label;
    
    public function __construct($name, $label) {
        $this->setName($name);
        $this->setLabel($label);
    }


    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getLabel() {
        return $this->label;
    }

    public function setLabel($label) {
        $this->label = $label;
    }
    
    /**
     * 
     * @param Model $model
     * @return type
     */
    public function showModel(Model $model)
    {
        return $model->{$this->getName()};
    }

    abstract public function getFormHtml();
}