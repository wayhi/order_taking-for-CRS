<?php

class Order extends Eloquent{

	protected $table = 'orders';
	protected $guarded = array('id');


	public function order_items(){
	
	
		return $this->hasMany('OrderItem','order_id');
	
	}
}