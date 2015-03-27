<?php

class Order extends Eloquent{

	protected $table = 'orders';
	protected $guarded = array('id');


	public function order_items(){
	
	
		return $this->hasMany('OrderItem','order_id');
	
	}

	public function activity(){

		return $this->belongsTo('Activity','activity_id','id');


	}

	public function owner(){

		return $this->belongsTo('User','owner_id','id');

	}
}