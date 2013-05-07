<?php

namespace Boyhagemann\Content\Controller;

use Boyhagemann\Pages\Model\Block;
use View;

class TestController extends \BaseController 
{
    public function form()
    {
        $model = Block::find(1);
                
        return View::make('content::test/form', compact('model'));
    }
}
