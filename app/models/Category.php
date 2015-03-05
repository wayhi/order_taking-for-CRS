<?php

class Category extends Eloquent{

	protected $table = 'category';
	protected $guarded = array('id');

	public function items(){
		
		return $this->hasMany('Item','category_id','id');
	
	
	}

}