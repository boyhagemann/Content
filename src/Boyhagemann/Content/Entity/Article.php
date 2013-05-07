<?php

namespace Boyhagemann\Content\Entity;

class Article 
{
    protected $title;
    
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

}