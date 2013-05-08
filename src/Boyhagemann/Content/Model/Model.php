<?php

namespace Boyhagemann\Content\Model;

class Model extends \Eloquent {
    protected $guarded = array();

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'models';
    
    public static $rules = array(
		'title' => 'required',
		'class' => 'required',
	);
    
}