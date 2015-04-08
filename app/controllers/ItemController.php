<?php
Namespace app\controllers;
use View, Sentry, User,DB, Redirect,Session,Request,URL,Cookie,Item, Order, Activity,ActivityItem,ItemSkin,Skin,Notification,Input,Debugbar;
class ItemController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$activity_id = Session::get('activity_id');
		$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)
			->orderby('created_at','desc')->paginate(9);
			return \View::make('items/index')->with('items',$items)->with('category',0);
		
		
		
		
	}

	public function category($category_id=0)
	{
		$activity_id = Session::get('activity_id');

		if($category_id==0){
			
			$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)
			->orderby('created_at','desc')->paginate(9);
			return \View::make('items/index')->with('items',$items)->with('category',0);
		
		}else{

			$items = ActivityItem::with('item.category')
			->whereraw("item_id in (select id from ccsc_item_master where category_id = ".$category_id.")")
			->where('activity_id',$activity_id)
			->orderby('created_at','desc')->paginate(9);
			return \View::make('items/index')->with('items',$items)->with('category',$category_id);
		
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('items/create');
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
		//$item=Item::find($id);
		$item=ActivityItem::with('item.category')->find($id);
		return View::make('items/show')->with('item',$item);
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
		->with('amount',$amount)->with('itemcount',$itemcount)->with('balance',$balance);
	
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

	public function search()
	{
		if(Input::has('search')){

			$search_string = Input::get('sn');
			if($search_string<>""){

				$activity_id = Session::get('activity_id');
				$items = ActivityItem::with('item.category')->where('activity_id',$activity_id)
				->whereIn('item_id',count(Item::where('item_name','like','%'.$search_string.'%')->orWhere('SKU_code',$search_string)->lists('id'))==0?[-1]:(Item::where('item_name','like','%'.$search_string.'%')
					->orWhere('SKU_code',$search_string)
					->lists('id')))
				->orderby('created_at','desc')->paginate(9);

				return \View::make('items/search')->with('items',$items)->with('search_string',$search_string);
			}else{
				return Redirect::back();
			}

		}else{

			return Redirect::back();

		}


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
}
