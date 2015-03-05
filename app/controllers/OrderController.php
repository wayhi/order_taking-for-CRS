<?php
Namespace app\controllers;
use View, Sentry, DB, Redirect,Request,URL,Cookie,Item,ItemSkin,Skin,Notification,Input,Order,OrderItem,Count,Crypt,Debugbar;
class OrderController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$orders = Order::where('owner_id',Sentry::getUser()->id)->orderBy('created_at','desc')->paginate(5);
		return \View::make('orders/index')->with('orders',$orders);
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		if(Input::has('submit') && (intval(Input::get('itemcount'))>0)){
			
			$order_new = DB::transaction(function(){
				
				$order = new Order();
				$order->activity_code= '';
				$order->order_number = Self::generate_order_number();
				$order->owner_id = Sentry::getUser()->id;
				$order->qty_total = 0;
				$order->amount_original = 0.00;
				$order->amount_actual = 0.00;
				$order->status = 1;
				$order->save();
				
				$itemcount = intval(Input::get('itemcount'));
				for($i =0;$i<$itemcount;$i++){
				
					$order_item = new OrderItem();
					$order_item->order_id = $order->id;
					$order_item->item_id = intval(Input::get('item_id'.$i));
					$order_item->qty = intval(Input::get('item_qty_'.$i));
					$order->qty_total += intval(Input::get('item_qty_'.$i));
					$order_item->price = floatval(Input::get('item_price'.$i));
					$order->amount_actual += floatval(Input::get('item_price'.$i))*$order_item->qty;
					$order_item->price_original = floatval(Input::get('item_price_o'.$i));
					$order->amount_original += floatval(Input::get('item_price_o'.$i))*$order_item->qty;
					$order_item->save();
					$order->save();
					
				}
				
				
				
				return $order;	
			});	
		
		
		
		}
		
		$cookie = Cookie::forget('item_id');
		return redirect::route('orders.index')->withCookie($cookie);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
	
		
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$uid = Crypt::decrypt($id);
		$order = Order::with('order_items','order_items.item')->find($uid);
		return View::make('orders.show')->with('order',$order);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
	
	private function generate_order_number(){
		
		$yearmonth = strval(Date("Y").Date("m"));
		$type_code = "IO".$yearmonth;
		
		$serial_record = Count::where('Year_Month',$yearmonth)->first();
		
		if($serial_record){
			
			$serial_no = intval($serial_record->serial_no)+1;
			$serial_record->serial_no = $serial_no;
			$serial_record->save();
			
		}else{
			
			$serial_record = new Count();
			$serial_record->Year_Month = $yearmonth;
			$serial_record->serial_no = 1;
			$serial_record->save();
			$serial_no=1;
			
		}
		
		return $type_code.strval(10000+$serial_no);
	}
	
}
