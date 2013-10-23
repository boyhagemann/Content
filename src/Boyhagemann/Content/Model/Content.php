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
        'page_id',
        'section_id',
        'block_id',
        'controller',
        'params',
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
			return $q->wherePageId($page->id)->orWhere('global', '=', 1);
		});

		return $query->get();
	}

}

