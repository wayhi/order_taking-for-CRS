<?php

class Activity extends Eloquent{

	protected $table = 'activities';
	protected $guarded = array('id');

	public function creator(){


		return $this->belongsTo('User','updated_by','id');


	}

	public function a_items(){


		return $this->hasMany('ActivityItem','activity_id','id');


	}

	public function orders(){

		return $this->hasMany('Order','activity_id','id');
	}



}