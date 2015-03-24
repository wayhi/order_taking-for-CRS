<?php

class ActivityItem extends Eloquent{

	protected $table = 'activity_items';
	protected $guarded = array('id');


	public function item()
	{

		return $this->belongsTo('Item','item_id','id');



	}

	public function activity()
	{

		return $this->belongsTo('Activity','activity_id','id');


	}



}