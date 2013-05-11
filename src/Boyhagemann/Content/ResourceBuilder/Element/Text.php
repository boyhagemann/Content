<?php

namespace Boyhagemann\Content\ResourceBuilder\Element;

use Form;

class Text extends BaseElement
{
    public function getFormHtml()
    {
        return Form::text($this->getName());
    }
}