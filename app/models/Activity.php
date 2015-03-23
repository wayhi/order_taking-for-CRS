<?php

class Activity extends Eloquent{

	protected $table = 'activities';
	protected $guarded = array('id');

	public function creator(){


	return $this->belongsTo('User','updated_by','id');


	}



}