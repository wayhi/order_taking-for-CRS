<?php

class OrderItem extends Eloquent{

	protected $table = 'order_items';
	protected $guarded = array('id');

	public function item(){
	
		return $this->belongsTo('Item','item_id','id');
	}

}