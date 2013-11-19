<?php

namespace Boyhagemann\Content\Model;

use Boyhagemann\Pages\Model\Page;
use Boyhagemann\Pages\Model\Section;

class Content extends \Eloquent
{
    protected $table = 'content';

    public $timestamps = false;

    public $rules = array();

    protected $guarded = array('id');

    protected $fillable = array(
        'layout_id',
        'page_id',
        'section_id',
        'block_id',
        'controller',
        'params',
		'position',
        'global'
        );

    /**
     * @return Page
     */
    public function page()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Page');
    }

	/**
	 * @return Layout
	 */
	public function layout()
	{
		return $this->belongsTo('Boyhagemann\Pages\Model\Layout');
	}

    /**
     * @return Section
     */
    public function section()
    {
        return $this->belongsTo('Boyhagemann\Pages\Model\Section');
    }

    /**
     * @return Block
     */
    public function block()
    {
        return $this->belongsTo('Boyhagemann\Content\Model\Block');
    }

    public function getParamsAttribute($value)
    {
        if(!$value) {
            return array();
        }
        
        return unserialize($value);
    }
    
    public function setParamsAttribute(Array $value = array())
    {
        $this->attributes['params'] = serialize($value);
    }

    /**
     * @param Page    $page
     * @param Section $section
     * @return mixed
     */
    static public function findByPageAndSection(Page $page, Section $section)
    {
            $query = self::whereSectionId($section->id)->where(function($q) use ($page) {
                    return $q->wherePageId($page->id)->orWhere('global', '=', 1)->orWhere('layout_id', '=', $page->layout->id);
            });

            return $query->orderBy('position')->get();
    }

	/**
	 * @return string
	 */
	public function getController()
	{
		if($this->block) {
			return $this->block->controller;
		}
		else {
			return $this->controller;
		}
	}

	/**
	 * @return bool
	 */
	public function hasConfigForm()
	{
		list($controller, $action) = explode('@', $this->getController());
		return method_exists($controller, $action . 'Config');
	}

}

