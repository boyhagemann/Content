<?php

namespace Boyhagemann\Content\Model;

use Boyhagemann\Pages\Model\Page as BasePage;

class Page extends BasePage
{
    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function content()
    {
        return $this->hasMany('Boyhagemann\Content\Model\Content');
    }


}

