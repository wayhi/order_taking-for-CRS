<?php
Namespace app\controllers;
use View, Sentry,Session, DB, ActivityItem,Excel,Redirect,Request,URL,Cookie,Item,
ItemSkin,Skin,Notification,Input,Order,OrderItem,Count,Crypt;

class OrderController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$orders = Order::with('activity')->where('owner_id',Sentry::getUser()->id)->orderBy('created_at','desc')->paginate(10);
		return \View::make('orders/index')->with('orders',$orders);
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$order_new = null;
		if(Input::has('submit') && (intval(Input::get('itemcount'))>0)){
			
			$order_new = DB::transaction(function(){
				
				$order = new Order();
				$order->activity_id= Session::get('activity_id');
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
					$item_id = intval(Input::get('item_id'.$i));
					$order_qty = intval(Input::get('item_qty_'.$i));
					$activityItem = ActivityItem::with('item')->where('activity_id',Session::get('activity_id'))
					->where('item_id',$item_id)
					->first();
					if($activityItem){
						$MoQ = $activityItem->MOQ;
						$item_limit = $activityItem->item_limit;
						$item_stock = $activityItem->item_stock;
						if($MoQ>0 && $order_qty<$MoQ){
							Notification::error('"'.$activityItem->item->item_name.'" 没有达到最小起订量！');
							DB::rollBack();
							Return null;
						}
						if($item_limit>0 && $order_qty>$item_limit){
							Notification::error('"'.$activityItem->item->item_name.'" 超过订购限量！');
							DB::rollBack();
							Return null;
						}
						//$item_ordered = OrderItem::where('item_id',$item_id)
						//->whereRaw('order_id in (select id from ccsc_orders 
						//	where activity_id ='.$activity_id.' and status>0)')
						//->sum('qty')
						$item_ordered = $activityItem->ordered;
						if($item_stock>0 && ($item_ordered+$order_qty>$item_stock)){

							Notification::error('"'.$activityItem->item->item_name.'" 库存不足！');
							DB::rollBack();
							Return null;

						}

					}
					
					
					$order_item->item_id = $item_id;
					$order_item->qty = $order_qty;
					$activityItem->ordered +=$order_qty;
					$activityItem->save();
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
		if($order_new){
			$cookie = Cookie::forget('item_id');
			return redirect::route('orders.index')->withCookie($cookie);
		}else{
			Return Redirect::back()->withInput();
		}
		
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
		$order = Order::with('order_items.item')->where('owner_id',Sentry::getUser()->id)->find($uid);
		if($order){
			return View::make('orders.show')->with('order',$order);
		}else{
			Notification::error('Visit Not Authorized!');
			return Redirect::route('orders.index');
		}
		
	}

	Public function admin($id)
	{
		$uid = Crypt::decrypt($id);
		$order = Order::with('order_items.item')->find($uid);
		if($order){
			return View::make('orders.show')->with('order',$order);
		}else{
			Notification::error('Visit Not Authorized!');
			return Redirect::route('orders.index');
		}
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

	public function manage($activity_id,$item_id=0,$user_id=0)
	{
		//$orders = Order::with('order_items.item','owner')->where('activity_id',$activity_id)->orderBy('created_at','desc')->paginate(10);
		//return \View::make('orders/manage')->with(['orders'=>$orders,,'item_id'=>$item_id,'user_id'=>$user_id]);

		if($item_id==0 && $user_id==0){
				$orders = Order::with('order_items.item','owner')->where('activity_id',$activity_id)->orderBy('created_at','desc')->paginate(10);
				return \View::make('orders/manage')->with(['orders'=>$orders,'item_id'=>$item_id,'user_id'=>$user_id]);
			}elseif($item_id<>0 and $user_id==0){
				
				//
				$orders = Order::with('order_items.item','owner')
				->where('activity_id',$activity_id)
				->whereRaw(DB::raw('id in (select order_id from ccsc_order_items where item_id='.$item_id.')'))
				->orderBy('created_at','desc')->paginate(10);
				return \View::make('orders/manage')->with(['orders'=>$orders,'item_id'=>$item_id,'user_id'=>$user_id]);

			}elseif($item_id==0 and $user_id<>0){
				$orders = Order::with('order_items.item','owner')
				->where('activity_id',$activity_id)
				->where('owner_id',$user_id)
				->orderBy('created_at','desc')->paginate(10);
				return \View::make('orders/manage')->with(['orders'=>$orders,'item_id'=>$item_id,'user_id'=>$user_id]);

			}else{

				$orders = Order::with('order_items.item','owner')
				->where('activity_id',$activity_id)
				->whereRaw(DB::raw('id in (select order_id from ccsc_order_items where item_id='.$item_id.')'))
				->where('owner_id',$user_id)
				->orderBy('created_at','desc')->paginate(10);
				return \View::make('orders/manage')->with(['orders'=>$orders,'item_id'=>$item_id,'user_id'=>$user_id]);

			}
		
	}

	public function search(){
		if(Input::has('submit')){

			$activity_id = Input::get('activity_id');
			$item_id = Input::get('item_id');
			$user_id = Input::get('user_id');

			return redirect::route('orders.manage',['activity_id'=>$activity_id,'item_id'=>$item_id,'user_id'=>$user_id])->withinput();
			

		}
		if(Input::has('export')){

			$activity_id = Input::get('activity_id');
			$item_id = Input::get('item_id');
			$user_id = Input::get('user_id');

			$orders = Order::with('order_items.item','owner')->where('activity_id',5)
			->orderBy('created_at','desc');
			
			
			Excel::create('Filename', function($excel) use($orders) {

    			$excel->sheet('Sheetname', function($sheet) use($orders) {
    				$main_arr[]=$orders->get()->toArray();
        			foreach($main_arr as $one){
                    $sheet->fromArray($one);
                }
        			$sheet->loadView('orders.export')->with('orders',$orders);

    			});

			})->download('xls');

		}


	}
	
}
