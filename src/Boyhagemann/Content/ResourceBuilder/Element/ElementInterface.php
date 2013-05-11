<?php

namespace Boyhagemann\Content\ResourceBuilder\Element;
use Illuminate\Database\Eloquent\Model;

interface ElementInterface
{
    public function getName();
    public function getLabel();
    public function showModel(Model $model);
    public function getFormHtml();
}