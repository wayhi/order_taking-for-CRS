<?php
Namespace app\controllers;
use View, Sentry,Session, DB,ActivityItem,Activity,Excel,Redirect,Request,URL,Cookie,Item,
ItemSkin,Skin,Notification,User,Input,Order,OrderItem,Count,Crypt;

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
			
			$total_amount = floatval(Input::get('totalamount'));
			$balance = self::getBalance(Session::get('activity_id'),Sentry::getUser()->id);
			if($total_amount>$balance){
				Notification::error("订购总金额超过限额！");
				return Redirect::back()->withInput();
			}
			$order_new = DB::transaction(function(){
				
				$order = new Order();
				$order->activity_id= Session::get('activity_id');
				$order->order_number = Self::generate_order_number();
				$order->owner_id = Sentry::getUser()->id;
				$order->qty_total = 0;
				$order->amount_original = 0.00;
				$order->amount_actual = 0.00;
				$order->status = 1;
				if(Input::has('pmt_method')){

					$order->pmt_method = 1;
				}else{
					$order->pmt_method = 0;
				}
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

	public function showcart(){
		$item_id = Cookie::get('item_id');
		$itemcount = 0;
		$items =null;
		$amount = 0.00;
		$balance = 0.00;
		$amount_limit = 0.00;
		$activity_id = Session::get('activity_id');
		$activity = Activity::find($activity_id);
		if($activity->activated==1){
			if(User::find(Sentry::getUser()->id)->quota>0){

				$amount_limit = User::find(Sentry::getUser()->id)->quota;
			}else{
				$amount_limit = $activity->amount_limit;
			}
			
			$balance = Self::getBalance($activity_id,Sentry::getUser()->id);
			$pmt_method = Self::getPmtMethod($activity_id,Sentry::getUser()->id);

		}

		if(is_array($item_id) ){
			$item_id = array_unique($item_id);
			$itemcount = count($item_id);
			if($itemcount>0){
				$items = ActivityItem::with('item')->whereIn('id',$item_id)->get();
				$amount = ActivityItem::whereIn('id',$item_id)->select(DB::raw('sum(offer_price) as amount'))->pluck('amount');
			}
			
		}
		
		
		if($balance<=100){
			Notification::errorInstant("本次活动限额 ¥".$amount_limit.", 剩余额度 ¥".$balance);
			//Notification::message("ok");
		}else{
			Notification::warningInstant("本次活动限额 ¥".$amount_limit.", 剩余额度 ¥".$balance);

		}
		return View::make('items/showcart')->with('items',$items)
		->with('amount',$amount)->with('itemcount',$itemcount)->with('balance',$balance)->with('pmt_method',$pmt_method);
	
	}
	
	public function clearcart(){
		$cookie = Cookie::forget('item_id');
		return redirect::route('showcart')->withCookie($cookie);
	}

	public function addtocart($item_id,$page=1){
		$item = ActivityItem::with('item')->find($item_id);
		$items_exist = Cookie::get('item_id');
		if(($items_exist)==null){
			$items_exist=[];
			//$items = array_add($items_exist,1,$item_id);
		}
		$items = array_add($items_exist,count($items_exist),$item_id);
		
		
		$cookie = Cookie::make('item_id',array_unique($items), 7200);

		Notification::success($item->item->item_name.'已加入您的购物车。');
		//Debugbar::info($url);
		return Redirect::route('items.index',['page'=>$page])->withCookie($cookie);
	
	}

	public function delfrmcart($item_id)
	{

		$item_list= Cookie::get('item_id');
		//Debugbar::info($item_list);
		
		if(is_array($item_list)){

				$keys = array_keys($item_list,$item_id);
				//Debugbar::info($keys);
				foreach($keys as $key){
					array_splice($item_list, $key, 1);

				}
				//Debugbar::info($item_list);

		}else{



		}

		$cookie = Cookie::make('item_id',$item_list, 7200);
		return Redirect::route('showcart')->withCookie($cookie)->withinput();
		//return View::make('items/showcart');

	}

	private static function getBalance($activity_id,$user_id)
	{
		$balance = 0.00;
		$used = Order::where('activity_id',$activity_id)->where('owner_id',$user_id)
			->sum('amount_actual');
		if(User::find($user_id)->quota>0){

				$limit = User::find($user_id)->quota;
			}else{
				$limit = Activity::find($activity_id)->amount_limit;
			}	
		
			
		$balance = $limit - $used;
		return $balance;

	}

	private static function getPmtMethod($activity_id,$user_id)
	{

		$pmt_method = -1;
		$order = Order::where('activity_id',$activity_id)->where('owner_id',$user_id)->first();
		
		if($order){

			if($order->pmt_method==1){
				$pmt_method = 1;
			}elseif($order->pmt_method==0){
				$pmt_method = 0;
			}
		}

		return $pmt_method;

	}
	
}
